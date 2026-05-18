<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('slug', 120)->unique();
            $table->text('description');
            $table->longText('long_description')->nullable();
            $table->string('repo_url', 255)->nullable();
            $table->string('live_url', 255)->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->json('tech_stack')->nullable();
            $table->unsignedInteger('github_stars')->default(0);
            $table->unsignedInteger('github_forks')->default(0);
            $table->timestamp('github_last_push')->nullable();
            $table->timestamp('github_synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
