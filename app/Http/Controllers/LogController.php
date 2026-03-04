<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $logs = ActionLog::with('user')
            ->latest()
            ->limit(200)
            ->get();

        return view('logs.index', compact('logs'));
    }
}
