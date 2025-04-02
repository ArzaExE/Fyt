<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin', compact('users'));
    }

    public function add(){
        return view('templates.addUser');
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users',
            'born_date' => 'required|date|before_or_equal:today',
            'address' => 'nullable|string|max:255',
            'postcode' => 'nullable|numeric|digits_between:3,10',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($this->user)
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user)
            ],
        ]);
    }
}
