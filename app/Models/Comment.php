<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A comment is attached to an idea and created by a user.
 *
 * Pedagogical goals:
 * - Base for XSS tests
 * - Base for authorization (Policy: only author can delete)
 * - Understand foreign keys and relations
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'idea_id',
        'user_id',
        'description',
        'is_flagged',
        'moderation_reason',
    ];

    /**
     * Comment belongs to Idea
     */
    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    /**
     * Comment belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
