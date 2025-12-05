<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The Idea model represents one idea posted by a user.
 *
 * Pedagogical goals:
 * - Understand Eloquent relationships (belongsTo, hasMany)
 * - Understand the $fillable protection mechanism
 * - Serve as an entry point for CRUD + vulnerabilities (XSS)
 */
class Idea extends Model
{
    use HasFactory;

    /**
     * Fields allowed for mass assignment.
     * This is intentionally permissive for pedagogical reasons.
     * Students will tighten this later.
     */
    protected $fillable = [
        'user_id',
        'application',
        'title',
        'description',
        'is_flagged',
        'moderation_reason',
        'votes',
    ];

    /**
     * An idea belongs to a user (the creator).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * An idea can have multiple comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
