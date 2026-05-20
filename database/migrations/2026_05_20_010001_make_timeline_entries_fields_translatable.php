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
        Schema::table('timeline_entries', function (Blueprint $table) {
            $table->json('title_json')->nullable()->after('title');
            $table->json('description_json')->nullable()->after('description');
        });

        DB::table('timeline_entries')->get()->each(function (object $row) {
            DB::table('timeline_entries')->where('id', $row->id)->update([
                'title_json'       => $row->title       !== null ? json_encode(['en' => $row->title])       : null,
                'description_json' => $row->description !== null ? json_encode(['en' => $row->description]) : null,
            ]);
        });

        Schema::table('timeline_entries', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });

        Schema::table('timeline_entries', function (Blueprint $table) {
            $table->renameColumn('title_json',       'title');
            $table->renameColumn('description_json', 'description');
        });
    }

    public function down(): void
    {
        Schema::table('timeline_entries', function (Blueprint $table) {
            $table->string('title_str', 120)->nullable()->after('title');
            $table->text('description_str')->nullable()->after('description');
        });

        DB::table('timeline_entries')->get()->each(function (object $row) {
            DB::table('timeline_entries')->where('id', $row->id)->update([
                'title_str'       => $row->title       ? (json_decode($row->title,       true)['en'] ?? null) : null,
                'description_str' => $row->description ? (json_decode($row->description, true)['en'] ?? null) : null,
            ]);
        });

        Schema::table('timeline_entries', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });

        Schema::table('timeline_entries', function (Blueprint $table) {
            $table->renameColumn('title_str',       'title');
            $table->renameColumn('description_str', 'description');
        });
    }
};
