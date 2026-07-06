<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('stores') && !Schema::hasColumn('stores', 'is_default_store')) {
            Schema::table('stores', function (Blueprint $table) {
                $table->tinyInteger('is_default_store')->default(0)->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('stores') && Schema::hasColumn('stores', 'is_default_store')) {
            Schema::table('stores', function (Blueprint $table) {
                $table->dropColumn('is_default_store');
            });
        }
    }
};
