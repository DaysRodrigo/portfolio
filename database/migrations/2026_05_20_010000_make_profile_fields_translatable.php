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
        // 1. Add temporary JSON columns
        Schema::table('profiles', function (Blueprint $table) {
            $table->json('job_title_json')->nullable()->after('job_title');
            $table->json('tagline_json')->nullable()->after('tagline');
            $table->json('about_json')->nullable()->after('about');
        });

        // 2. Migrate existing values into {"en": "value"} JSON
        DB::table('profiles')->get()->each(function (object $row) {
            DB::table('profiles')->where('id', $row->id)->update([
                'job_title_json' => $row->job_title !== null ? json_encode(['en' => $row->job_title]) : null,
                'tagline_json'   => $row->tagline   !== null ? json_encode(['en' => $row->tagline])   : null,
                'about_json'     => $row->about     !== null ? json_encode(['en' => $row->about])     : null,
            ]);
        });

        // 3. Drop old columns
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['job_title', 'tagline', 'about']);
        });

        // 4. Rename JSON columns to original names
        Schema::table('profiles', function (Blueprint $table) {
            $table->renameColumn('job_title_json', 'job_title');
            $table->renameColumn('tagline_json',   'tagline');
            $table->renameColumn('about_json',     'about');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('job_title_str', 100)->nullable()->after('job_title');
            $table->string('tagline_str', 255)->nullable()->after('tagline');
            $table->text('about_str')->nullable()->after('about');
        });

        DB::table('profiles')->get()->each(function (object $row) {
            $jobTitle = $row->job_title ? (json_decode($row->job_title, true)['en'] ?? null) : null;
            $tagline  = $row->tagline   ? (json_decode($row->tagline,   true)['en'] ?? null) : null;
            $about    = $row->about     ? (json_decode($row->about,     true)['en'] ?? null) : null;

            DB::table('profiles')->where('id', $row->id)->update([
                'job_title_str' => $jobTitle,
                'tagline_str'   => $tagline,
                'about_str'     => $about,
            ]);
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['job_title', 'tagline', 'about']);
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->renameColumn('job_title_str', 'job_title');
            $table->renameColumn('tagline_str',   'tagline');
            $table->renameColumn('about_str',     'about');
        });
    }
};
