<?php

namespace App\Providers;

use App\Models\Idea;
use App\Models\Comment;
use App\Policies\IdeaPolicy;
use App\Policies\CommentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * NOTE:
     * Policies are intentionally permissive for the sandbox.
     * Secure them
     */
    protected $policies = [
        Idea::class => IdeaPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
