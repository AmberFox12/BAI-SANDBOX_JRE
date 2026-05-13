<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * This controller contains a DELIBERATELY vulnerable redirect.
 *
 * TODO
 * - detect it during ZAP scan
 * - fix it with domain validation
 */
class RedirectController extends Controller
{
    public function vulnerableRedirect(Request $request)
    {
        $url = $request->query('url', '/');
        $allowed = ['https://google.com', 'https://laravel.com'];

        if (!in_array($url, $allowed)) {
            return redirect('/');
        }

        return redirect($url);
    }
}
