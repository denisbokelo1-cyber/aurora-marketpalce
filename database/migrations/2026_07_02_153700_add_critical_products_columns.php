<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ===== PRODUCTS =====
        if (Schema::hasTable('products')) {
            if (!Schema::hasColumn('products', 'store_id'))
                Schema::table('products', fn(Blueprint $t) => $t->integer('store_id')->nullable()->default(0)->after('id'));

            if (!Schema::hasColumn('products', 'price'))
                Schema::table('products', fn(Blueprint $t) => $t->decimal('price', 10, 2)->default(0)->after('tax'));

            if (!Schema::hasColumn('products', 'discounted_price'))
                Schema::table('products', fn(Blueprint $t) => $t->decimal('discounted_price', 10, 2)->default(0)->after('price'));

            if (!Schema::hasColumn('products', 'tax_type'))
                Schema::table('products', fn(Blueprint $t) => $t->string('tax_type')->nullable()->after('tax'));
        }

        // ===== ORDER ITEMS =====
        if (Schema::hasTable('order_items')) {
            if (!Schema::hasColumn('order_items', 'price'))
                Schema::table('order_items', fn(Blueprint $t) => $t->decimal('price', 10, 2)->default(0)->after('product_variant_id'));

            if (!Schema::hasColumn('order_items', 'sub_total'))
                Schema::table('order_items', fn(Blueprint $t) => $t->decimal('sub_total', 10, 2)->default(0)->after('price'));
        }

        // ===== CATEGORIES =====
        if (Schema::hasTable('categories')) {
            if (!Schema::hasColumn('categories', 'store_id'))
                Schema::table('categories', fn(Blueprint $t) => $t->integer('store_id')->nullable()->default(0)->after('id'));

            if (!Schema::hasColumn('categories', 'row_order'))
                Schema::table('categories', fn(Blueprint $t) => $t->integer('row_order')->default(0)->after('status'));
        }

        // ===== OFFERS =====
        if (Schema::hasTable('offers')) {
            if (!Schema::hasColumn('offers', 'store_id'))
                Schema::table('offers', fn(Blueprint $t) => $t->integer('store_id')->nullable()->default(0)->after('id'));
            if (!Schema::hasColumn('offers', 'type_id'))
                Schema::table('offers', fn(Blueprint $t) => $t->integer('type_id')->nullable()->after('type'));
            if (!Schema::hasColumn('offers', 'image'))
                Schema::table('offers', fn(Blueprint $t) => $t->string('image')->nullable()->after('type_id'));
            if (!Schema::hasColumn('offers', 'banner_image'))
                Schema::table('offers', fn(Blueprint $t) => $t->string('banner_image')->nullable()->after('image'));
        }
    }

    public function down(): void
    {
        // no down
    }
};
