<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('seller_store') && !Schema::hasColumn('seller_store', 'status')) {
            Schema::table('seller_store', function (Blueprint $table) {
                $table->tinyInteger('status')->default(1)->after('store_description');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('seller_store') && Schema::hasColumn('seller_store', 'status')) {
            Schema::table('seller_store', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
