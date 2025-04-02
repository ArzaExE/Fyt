<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
class ShippingController extends Controller
{
    public function show(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ShippingUpdateRequest $request)
    {
        $request->user()->fill($request->validated());
        $request->user()->save();

        return Redirect::route('shipping.update')->with('status', 'shipping-updated');
    }


}
