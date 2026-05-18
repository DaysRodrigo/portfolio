<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();
            $table->enum('category', ['backend', 'frontend', 'devops', 'database', 'tools']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_tags');
    }
};
