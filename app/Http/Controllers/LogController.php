<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;

/**
 * Minimal admin log view.
 *
 * SECURITY NOTE:
 * - No role verification login ANY authenticated user can access logs (TODO)
 *   Secure it by adding a real admin policy.
 */
class LogController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $logs = ActionLog::with('user')
            ->latest()
            ->limit(200)
            ->get();

        return view('logs.index', compact('logs'));
    }
}
