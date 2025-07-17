<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function request(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|min:5',
        ]);
        // Here you could store to DB, send email, etc.
        // For now, just log it
        \Log::info('Help request', [
            'email' => $request->email,
            'message' => $request->message,
        ]);
        return response()->json(['success' => true]);
    }
} 