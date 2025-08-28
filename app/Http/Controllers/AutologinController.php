<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AutologinController extends Controller
{
    public function impersonate(Request $request, $userId)
    {
        // Store the original user's ID in the session
        if (!$request->session()->has('impersonator_id')) {
            $request->session()->put('impersonator_id', Auth::id());
            $request->session()->put('impersonator_type', $request->type);
        }

        // Log in as the new user using their ID
        Auth::loginUsingId($userId);

        return redirect()->route('dashboard'); // Redirect to the dashboard or any route you need
    }
}
