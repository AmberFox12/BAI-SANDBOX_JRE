<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();

            // Author of the idea
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Context or application name (for your sandbox)
            $table->string('application')->nullable();

            $table->string('title');
            $table->text('description');

            // Moderation fields (used later in the course)
            $table->boolean('is_flagged')->default(false);
            $table->string('moderation_reason')->nullable();

            // Simple vote counter (can be used later)
            $table->unsignedInteger('votes')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
