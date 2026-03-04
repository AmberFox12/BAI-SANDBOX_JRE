<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ActionLog stores every action performed in the application.
 *
 * Pedagogical goals:
 * - Introduce security logging (ANSSI good practices)
 * - Allow detection of suspicious patterns later
 * - Support exercises: purge logs, filter logs, improve logging
 */
class ActionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'idea_id',
        'comment_id',
        'data_before',
        'data_after',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Extract browser name from the user agent string.
     */
    private function parseBrowser(): string
    {
        $ua = $this->user_agent ?? '';

        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Edg')) return 'Edge';
        if (str_contains($ua, 'Chrome')) return 'Chrome';
        if (str_contains($ua, 'Safari')) return 'Safari';
        if (str_contains($ua, 'Opera')) return 'Opera';

        return 'Autre';
    }

    /**
     * Generate a human-readable description based on the action type.
     */
    public function getDetailsAttribute(): string
    {
        return match ($this->action) {
            'login'  => $this->parseBrowser(),
            default  => '-',
        };
    }
}
