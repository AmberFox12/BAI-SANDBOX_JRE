<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User $user, Comment $comment): bool
    {
        // TODO: restrict deletion to:
        // - the comment author
        // - OR an admin
        return true; // Vulnerable on purpose
    }
}
