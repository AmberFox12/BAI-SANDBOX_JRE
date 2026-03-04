<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Comment;
use App\Models\ActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsible for comments on ideas.
 *
 * NOTE:
 * - No validation (TODO)
 * - No limit per user (add max 3 comments per idea) (TODO)
 * - No authorization on delete (TODO secure)
 */
class CommentController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Store a new comment for an idea.
     */
    public function store(Request $request, Idea $idea)
    {
        $comment = Comment::create([
            'idea_id'     => $idea->id,
            'user_id'     => Auth::id(),
            'description' => $request->input('description'), // XSS vulnerable
        ]);
        ActionLog::create([
                'user_id' => Auth::id(),
                'action' => 'comment_created',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'idea_id' => $idea->id,
                'comment_id' => $comment->id,
        ]);

        return redirect()
            ->route('ideas.show', $idea)
            ->with('status', 'Comment added.');
    }

    /**
     * Remove a comment.
     *
     * NOTE:
     * - No authorization check ANY user can delete ANY comment (TODO)
     */
    public function destroy(Idea $idea, Comment $comment)
    {
        $this->authorize('delete', $comment); // Authorization check using the CommentPolicy
        ActionLog::create([
                'user_id' => Auth::id(),
                'action' => 'comment_deleted',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'idea_id' => $idea->id,
                'comment_id' => $comment->id,
        ]);
        $comment->delete();

        return redirect()
            ->route('ideas.show', $idea)
            ->with('status', 'Comment deleted.');
    }
}
