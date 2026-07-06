<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // brands - missing store_id
        if (Schema::hasTable('brands') && !Schema::hasColumn('brands', 'store_id')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->integer('store_id')->default(0)->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('brands') && Schema::hasColumn('brands', 'store_id')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};
