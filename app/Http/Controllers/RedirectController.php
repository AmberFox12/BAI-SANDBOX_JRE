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
        // Any external URL is allowed → huge security flaw !!!!!!!!!!!!!
        $url = $request->query('url', '/');

        return redirect($url);
    }
}
