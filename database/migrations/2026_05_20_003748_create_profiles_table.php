<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('job_title', 100);
            $table->string('tagline', 255);
            $table->text('about')->nullable();
            $table->string('github_url', 255)->nullable();
            $table->string('github_username', 100)->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('linkedin_username', 100)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('whatsapp_label', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
