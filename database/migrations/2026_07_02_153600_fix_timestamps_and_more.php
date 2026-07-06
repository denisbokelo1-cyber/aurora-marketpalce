<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix order_items
        if (Schema::hasTable('order_items')) {
            if (!Schema::hasColumn('order_items', 'created_at')) {
                Schema::table('order_items', fn(Blueprint $t) => $t->timestamp('created_at')->nullable()->useCurrent());
            }
            if (!Schema::hasColumn('order_items', 'updated_at')) {
                Schema::table('order_items', fn(Blueprint $t) => $t->timestamp('updated_at')->nullable()->useCurrentOnUpdate());
            }
            if (!Schema::hasColumn('order_items', 'order_type')) {
                Schema::table('order_items', fn(Blueprint $t) => $t->string('order_type')->default('regular_order')->after('store_id'));
            }
        }
    }

    public function down(): void
    {
        // No down - fix migration
    }
};
