<?php

namespace App\Services\Logging;

use App\Models\ActionLog;
use Illuminate\Http\Request;

/**
 * Service responsible for logging security-relevant actions.
 *
 * TODO later:
 *  - Improve what is logged
 *  - Add classifications
 *  - Add filtering in logs page
 *  - Add retention rules (purge)
 */
class ActionLogService
{
    public function log(
        ?int $userId,
        string $action,
        ?int $ideaId = null,
        ?int $commentId = null,
        ?string $dataBefore = null,
        ?string $dataAfter = null,
        ?Request $request = null
    ): void {
        ActionLog::create([
            'user_id' => $userId,
            'action' => $action,
            'idea_id' => $ideaId,
            'comment_id' => $commentId,
            'data_before' => $dataBefore,
            'data_after' => $dataAfter,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}
