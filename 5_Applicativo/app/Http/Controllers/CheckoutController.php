<?php

namespace App\Http\Controllers;


use App\Http\Requests\AdminUpdateRequest;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\ProductImage;
use App\Models\ProductSizesAndQuantities;
use App\Models\User;
use App\Models\user_roles;
use Error;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function index(){
        return view('checkout');
    }

    public function showStatus(Request $request){
        $session_id = $request->query('session_id');

        if ($session_id != null){
            $cart = Order::where('user_id', auth()->id())->where('status', 'cart')->first();
            if ($cart){
                $items = OrderItems::where('order_id', $cart->id)->get();

                foreach ($items as $item){
                    ProductSizesAndQuantities::where('product_id', $item->product_id)
                        ->where('id', $item->size_id)->first()
                        ->decrement('stock', $item->quantity);
                }

                $cart->update([
                    'status' => 'paid'
                ]);

                return view('return', compact('items', 'cart'));
            }else{
                return redirect()->route('catalog');
            }
        }
        else{
            return redirect()->route('home');
        }
    }
    public function orderCartItems($items){
        $cartItems = [];

        foreach ($items as $item){
            $image = ProductImage::where('product_id', $item->product->id)
                ->where('is_main', 1)
                ->first();
            $cartItems[] = [
                'name' => $item->product->name,
                'description' => $item->product->description,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'image' => asset('productImages' . $image->image)
            ];
        }


        $lineItems = array_map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'images' => array($item['image'])
                    ],
                    'unit_amount' => $item['price']*100,
                ],
                'quantity' => $item['quantity'],
            ];
        }, $cartItems);

        return $lineItems;
    }
    public function create()
    {
        $curl = new \Stripe\HttpClient\CurlClient([CURLOPT_PROXY => 'proxy.cpt.local:8080']);
        // tell Stripe to use the tweaked client
        \Stripe\ApiRequestor::setHttpClient($curl);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $cart = Order::where('user_id', auth()->id())->where('status', 'cart')->firstOrFail();
        $items = $cart->items()->with('product')->get();

        $cartItems = $this->orderCartItems($items);
        header('Content-Type: application/json');


        $checkout_session = $stripe->checkout->sessions->create([
            'ui_mode' => 'embedded',
            'line_items' => $cartItems,
            'mode' => 'payment',
            'return_url' => env('APP_URL'). ':8000' . '/status?session_id={CHECKOUT_SESSION_ID}',
        ]);

        echo json_encode(array('clientSecret' => $checkout_session->client_secret));
    }

    public function status(){
        $curl = new \Stripe\HttpClient\CurlClient([CURLOPT_PROXY => 'proxy.cpt.local:8080']);
        // tell Stripe to use the tweaked client
        \Stripe\ApiRequestor::setHttpClient($curl);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        header('Content-Type: application/json');
        try {
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            $session = $stripe->checkout->sessions->retrieve($jsonObj->session_id);

            echo json_encode(['status' => $session->status, 'amount_total' => $session->amount_total]);
            http_response_code(200);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
