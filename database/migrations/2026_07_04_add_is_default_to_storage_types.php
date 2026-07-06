<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('storage_types') && !Schema::hasColumn('storage_types', 'is_default')) {
            Schema::table('storage_types', function (Blueprint $table) {
                $table->boolean('is_default')->default(0)->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('storage_types') && Schema::hasColumn('storage_types', 'is_default')) {
            Schema::table('storage_types', function (Blueprint $table) {
                $table->dropColumn('is_default');
            });
        }
    }
};
