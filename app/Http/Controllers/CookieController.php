<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CookieController extends Controller {

    /**
     * Handle cookie acceptance.
     */
    public function acceptation(Request $request)
    {
        Auth::user()->update(['cookies_status' => 'accepted']);
        return redirect()->back();
    }

    /**
     * Handle cookie refusal.
     */
    public function refusal(Request $request)
    {
        Auth::user()->update(['cookies_status' => 'refused']);
        return redirect()->back();
    }
}