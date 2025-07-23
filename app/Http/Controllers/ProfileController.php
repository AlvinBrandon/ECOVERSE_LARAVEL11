<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        return view('pages.profile');
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $attributes = $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required',
            'phone' => 'nullable|max:20',
            'about' => 'nullable|max:500',
            'location' => 'nullable|max:255'
        ]);

        $user->update($attributes);
        return back()->with('success', 'Profile successfully updated.');
    }

    public function settings()
    {
        return view('pages.profile-settings');
    }
}
