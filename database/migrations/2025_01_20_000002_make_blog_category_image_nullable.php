<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('blog_categories', function (Blueprint $table) {
                $table->string('image', 255)->nullable()->change();
            });
        } catch (\Exception $e) {
            // Skip if table doesn't exist
        }
    }

    public function down(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('image', 255)->nullable(false)->change();
        });
    }
};
