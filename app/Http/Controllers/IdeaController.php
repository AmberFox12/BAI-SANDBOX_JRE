<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Models\ActionLog;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsible for managing ideas.
 *
 * NOTE:
 * - No validation (voluntary vulnerabilities for the cybersecurity exercises) (TODO)
 * - No authorization (TODO)
 * - XSS not escaped in the views (TODO)
 */
class IdeaController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display all ideas.
     */
    public function index()
    {
        // Loads ideas with their authors (simple pagination)
        $ideas = Idea::with('user')
            ->latest()
            ->paginate(10);

        return view('ideas.index', compact('ideas'));
    }

    /**
     * Show the form to create a new idea.
     */
    public function create()
    {
        return view('ideas.create');
    }

    /**
     * Store a newly created idea.
     *
     * SECURITY NOTE:
     * - No validation (TODO)
     * - No rate limiting (TODO)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'application' => ['nullable', 'string', 'max:255'],
        ]);

         // Validate the request data (currently not implemented, TODO)
        $idea = Idea::create([
            'user_id'     => Auth::id(),
            'title'       => $validated['title'],
            'description' => $validated['description'], // XSS not escaped
            'application' => $validated['application'],
        ]);
        ActionLog::create([
                'user_id' => Auth::id(),
                'action' => 'idea_created',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'idea_id' => $idea->id,
        ]);
        return redirect()
            ->route('ideas.show', $idea)
            ->with('status', 'Idea created (vulnerable version).');
    }

    /**
     * Display the specified idea.
     */
    public function show(Idea $idea)
    {
        $idea->load('comments.user');
        return view('ideas.show', compact('idea'));
    }

    /**
     * Show edit form.
     *
     * SECURITY NOTE:
     * - No authorization: ANY user can edit ANY idea (intentionally vulnerable) (TODO)
     */
    public function edit(Idea $idea)
    {
        $this->authorize('update', $idea); // Authorization check using the IdeaPolicy
        ActionLog::create([
                'user_id' => Auth::id(),
                'action' => 'idea_edited',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'idea_id' => $idea->id,
        ]);
        return view('ideas.edit', compact('idea'));
    }

    /**
     * Update the idea.
     */
    public function update(Request $request, Idea $idea)
    {
         $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'application' => ['nullable', 'string', 'max:255'],
        ]);
        $this->authorize('update', $idea); // Authorization check using the IdeaPolicy
        
        $idea->update([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'application' => $validated['application'],
        ]);
        ActionLog::create([
                'user_id' => Auth::id(),
                'action' => 'idea_updated',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'idea_id' => $idea->id,
                'data_before' => json_encode($idea->getOriginal()), // Store original data before update
                'data_after' => json_encode($idea->getAttributes()), // Store new data after update
        ]);
        return redirect()
            ->route('ideas.show', $idea)
            ->with('status', 'Idea updated.');
    }

    /**
     * Remove an idea.
     *
     * SECURITY NOTE:
     * - No authorization check  ANY user can delete ANY idea (TODO)
     */
    public function destroy(Idea $idea)
    {
        $this->authorize('delete', $idea); // Authorization check using the IdeaPolicy
        ActionLog::create([
                'user_id' => Auth::id(),
                'action' => 'idea_deleted',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'idea_id' => $idea->id,
        ]);
        $idea->delete();        
        return redirect()
            ->route('ideas.index')
            ->with('status', 'Idea deleted.');
    }
}
