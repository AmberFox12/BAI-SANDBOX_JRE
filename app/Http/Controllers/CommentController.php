<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Comment;
use App\Models\ActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment for an idea.
     * Max 3 comments per day per user.
     */
    public function store(Request $request, Idea $idea)
    {
        $request->validate([
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $todayCount = Comment::where('user_id', Auth::id())
            ->whereDate('created_at', now()->toDateString())
            ->count();

        if ($todayCount >= 3) {
            return redirect()
                ->route('ideas.show', $idea)
                ->with('error', 'Vous avez atteint la limite de 3 commentaires par jour.');
        }

        $comment = Comment::create([
            'idea_id'     => $idea->id,
            'user_id'     => Auth::id(),
            'description' => $request->input('description'),
        ]);

        ActionLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'comment_created',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'idea_id'    => $idea->id,
            'comment_id' => $comment->id,
        ]);

        return redirect()
            ->route('ideas.show', $idea)
            ->with('status', 'Comment added.');
    }

    /**
     * Update a comment.
     */
    public function update(Request $request, Idea $idea, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $comment->update([
            'description' => $request->input('description'),
        ]);

        ActionLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'comment_updated',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'idea_id'    => $idea->id,
            'comment_id' => $comment->id,
        ]);

        return redirect()
            ->route('ideas.show', $idea)
            ->with('status', 'Comment updated.');
    }

    /**
     * Remove a comment.
     */
    public function destroy(Idea $idea, Comment $comment)
    {
        $this->authorize('delete', $comment);

        ActionLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'comment_deleted',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'idea_id'    => $idea->id,
            'comment_id' => $comment->id,
        ]);

        $comment->delete();

        return redirect()
            ->route('ideas.show', $idea)
            ->with('status', 'Comment deleted.');
    }
}