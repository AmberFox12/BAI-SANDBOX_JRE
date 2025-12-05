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
        // TODO
        return true; // Vulnerable on purpose
    }

    public function delete(User $user, Idea $idea): bool
    {
        // TODO
        return true;
    }
}
