<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sliders') && !Schema::hasColumn('sliders', 'store_id')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->integer('store_id')->nullable()->default(0)->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('sliders') && Schema::hasColumn('sliders', 'store_id')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};
