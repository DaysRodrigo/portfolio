<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('title_json')->nullable()->after('title');
            $table->json('description_json')->nullable()->after('description');
            $table->json('long_description_json')->nullable()->after('long_description');
        });

        DB::table('projects')->get()->each(function (object $row) {
            DB::table('projects')->where('id', $row->id)->update([
                'title_json'            => $row->title            !== null ? json_encode(['en' => $row->title])            : null,
                'description_json'      => $row->description      !== null ? json_encode(['en' => $row->description])      : null,
                'long_description_json' => $row->long_description !== null ? json_encode(['en' => $row->long_description]) : null,
            ]);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'long_description']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->renameColumn('title_json',            'title');
            $table->renameColumn('description_json',      'description');
            $table->renameColumn('long_description_json', 'long_description');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title_str', 120)->nullable()->after('title');
            $table->text('description_str')->nullable()->after('description');
            $table->longText('long_description_str')->nullable()->after('long_description');
        });

        DB::table('projects')->get()->each(function (object $row) {
            DB::table('projects')->where('id', $row->id)->update([
                'title_str'            => $row->title            ? (json_decode($row->title,            true)['en'] ?? null) : null,
                'description_str'      => $row->description      ? (json_decode($row->description,      true)['en'] ?? null) : null,
                'long_description_str' => $row->long_description ? (json_decode($row->long_description, true)['en'] ?? null) : null,
            ]);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'long_description']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->renameColumn('title_str',            'title');
            $table->renameColumn('description_str',      'description');
            $table->renameColumn('long_description_str', 'long_description');
        });
    }
};
