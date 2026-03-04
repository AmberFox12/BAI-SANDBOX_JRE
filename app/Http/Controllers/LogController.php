<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        // On commence avec une requete de base (sans filtre)
        $query = ActionLog::with('user');

        // Si l'utilisateur a choisi une date, on filtre par cette date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        // Si l'utilisateur a choisi une action, on filtre par cette action
        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        $logs = $query->latest()->limit(200)->get();

        // Liste des actions distinctes pour le menu deroulant
        $actions = ActionLog::select('action')->distinct()->orderBy('action')->pluck('action');

        return view('logs.index', compact('logs', 'actions'));
    }
}
