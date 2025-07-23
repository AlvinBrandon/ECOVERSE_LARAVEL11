<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        ]);

        $user = User::create($attributes);
        Auth::login($user);
        
        // Try to send email verification notification
        try {
            $user->sendEmailVerificationNotification();
            return redirect('/email/verify')->with('success', 'Registration successful! Please check your email to verify your account.');
        } catch (\Exception $e) {
            // If email fails, still redirect to verification page with different message
            return redirect('/email/verify')->with('info', 'Registration successful! Email verification is temporarily unavailable. Please contact an administrator.');
    } 
}

}
