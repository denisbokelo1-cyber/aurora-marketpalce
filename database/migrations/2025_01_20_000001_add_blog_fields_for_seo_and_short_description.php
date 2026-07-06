<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('blogs', function (Blueprint $table) {
                $table->text('short_description')->nullable()->after('description');
                $table->string('meta_title', 255)->nullable()->after('short_description');
                $table->text('meta_description')->nullable()->after('meta_title');
                $table->text('meta_keywords')->nullable()->after('meta_description');
            });
        } catch (\Exception $e) {
            // Skip if table doesn't exist
        }
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['short_description', 'meta_title', 'meta_description', 'meta_keywords']);
        });
    }
};
