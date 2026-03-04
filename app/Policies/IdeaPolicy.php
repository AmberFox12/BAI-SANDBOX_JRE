<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;

class IdeaPolicy
{
    /**
     * Determine if the given user can update the idea.
     */
    public function update(User $user, Idea $idea): bool
    {
        if ($user->id === $idea->user_id) {
            return true;
        }
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Idea $idea): bool
    {
        if ($user->id === $idea->user_id) {
            return true; // Check if the user is the owner of the idea
        }
        if ($user->is_admin) {
            return true; // Check if the user is an admin
        }
        return false;
    }
}
