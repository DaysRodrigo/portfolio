<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timeline_entries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['work', 'education']);
            $table->string('title', 120);
            $table->string('organization', 120);
            $table->string('location', 120);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description');
            $table->json('skills')->nullable();
            $table->smallInteger('display_order')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timeline_entries');
    }
};
