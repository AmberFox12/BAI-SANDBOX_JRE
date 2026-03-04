<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class CookieController extends Controller {

    /**
     * Handle cookie acceptance.
     */
    public function acceptation(Request $request)
    {
        User::where('id', Auth::id())->update(['cookies_status' => 'accepted']);
        return redirect()->back();
    }

    /**
     * Handle cookie refusal.
     */
    public function refusal(Request $request)
    {
        User::where('id', Auth::id())->update(['cookies_status' => 'refused']);
        return redirect()->back();
    }

    /**
     * Update cookies_status from profile page.
     */
    public function updateCookies(Request $request)
    {
        $status = $request->input('cookies_status');

        if (in_array($status, ['accepted', 'refused'])) {
            User::where('id', Auth::id())->update(['cookies_status' => $status]);
        }

        return redirect()->route('profile.show');
    }
}