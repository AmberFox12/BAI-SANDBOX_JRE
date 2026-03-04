<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User $user, Comment $comment): bool
    {
        if ($user->id === $comment->user_id) {
            return true; // Check if the user is the owner of the comment
        }
        if ($user->is_admin) {
            return true; // Check if the user is an admin
        }
        return false;
    }
}
