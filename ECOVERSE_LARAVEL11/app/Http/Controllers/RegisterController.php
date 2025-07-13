<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(){

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            'role' => 'required|in:customer,supplier,retailer,wholesaler',
        ]);

        $user = User::create($attributes);
        auth()->login($user);
        if ($user->role === 'supplier') {
            return redirect()->route('supplier.dashboard');
        }
        return redirect('/dashboard');
    } 
}
