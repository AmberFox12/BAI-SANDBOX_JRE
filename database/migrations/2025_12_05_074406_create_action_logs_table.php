<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('action_logs', function (Blueprint $table) {
            $table->id();

            // User who triggered the action (can be null for guests)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Action type: "idea_created", "comment_deleted", "login", etc.
            $table->string('action');

            // Optional links to idea or comment
            $table->unsignedBigInteger('idea_id')->nullable();
            $table->unsignedBigInteger('comment_id')->nullable();

            // Before/after data (JSON or plain text)
            $table->text('data_before')->nullable();
            $table->text('data_after')->nullable();

            // Technical information (for security / traceability)
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('action_logs');
    }
};
