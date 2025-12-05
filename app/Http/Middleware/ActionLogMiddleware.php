<?php

namespace App\Http\Middleware;

use App\Services\Logging\ActionLogService;
use Closure;
use Illuminate\Http\Request;

/**
 * Middleware that logs every HTTP request.
 *
 * Pedagogical goals:
 * - Introduce logging pipelines
 * - Show how middleware works
 * - Enable students to identify excessive logging
 * - Prepare exercises to reduce log noise!
 */
class ActionLogMiddleware
{
    public function __construct(
        private readonly ActionLogService $logger
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $user = $request->user();
        $userId = $user ? $user->id : null;

        $action = sprintf(
            'HTTP %s %s',
            $request->getMethod(),
            $request->path()
        );

        $this->logger->log(
            userId: $userId,
            action: $action,
            request: $request
        );
        $request->session()->forget('_token');

        return $response;
    }
}
