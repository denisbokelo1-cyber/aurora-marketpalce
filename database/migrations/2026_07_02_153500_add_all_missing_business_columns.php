<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ========== SECTIONS ==========
        if (Schema::hasTable('sections')) {
            if (!Schema::hasColumn('sections', 'store_id')) Schema::table('sections', fn(Blueprint $t) => $t->integer('store_id')->nullable()->after('id'));
            if (!Schema::hasColumn('sections', 'title')) Schema::table('sections', fn(Blueprint $t) => $t->string('title')->nullable()->after('store_id'));
            if (!Schema::hasColumn('sections', 'short_description')) Schema::table('sections', fn(Blueprint $t) => $t->text('short_description')->nullable()->after('title'));
            if (!Schema::hasColumn('sections', 'product_ids')) Schema::table('sections', fn(Blueprint $t) => $t->text('product_ids')->nullable()->after('short_description'));
            if (!Schema::hasColumn('sections', 'product_type')) Schema::table('sections', fn(Blueprint $t) => $t->string('product_type')->nullable()->after('product_ids'));
            if (!Schema::hasColumn('sections', 'categories')) Schema::table('sections', fn(Blueprint $t) => $t->text('categories')->nullable()->after('product_type'));
            if (!Schema::hasColumn('sections', 'style')) Schema::table('sections', fn(Blueprint $t) => $t->string('style')->nullable()->after('categories'));
            if (!Schema::hasColumn('sections', 'banner_image')) Schema::table('sections', fn(Blueprint $t) => $t->string('banner_image')->nullable()->after('style'));
            if (!Schema::hasColumn('sections', 'row_order')) Schema::table('sections', fn(Blueprint $t) => $t->integer('row_order')->default(0)->after('banner_image'));
        }

        // ========== OFFERS ==========
        if (Schema::hasTable('offers')) {
            if (!Schema::hasColumn('offers', 'store_id')) Schema::table('offers', fn(Blueprint $t) => $t->integer('store_id')->nullable()->after('id'));
            if (!Schema::hasColumn('offers', 'type_id')) Schema::table('offers', fn(Blueprint $t) => $t->integer('type_id')->nullable()->after('type'));
            if (!Schema::hasColumn('offers', 'image')) Schema::table('offers', fn(Blueprint $t) => $t->string('image')->nullable()->after('type_id'));
            if (!Schema::hasColumn('offers', 'banner_image')) Schema::table('offers', fn(Blueprint $t) => $t->string('banner_image')->nullable()->after('image'));
        }

        // ========== BLOGS ==========
        if (Schema::hasTable('blogs')) {
            if (!Schema::hasColumn('blogs', 'store_id')) Schema::table('blogs', fn(Blueprint $t) => $t->integer('store_id')->nullable()->after('id'));
        }

        // ========== CART ==========
        if (Schema::hasTable('cart')) {
            if (!Schema::hasColumn('cart', 'store_id')) Schema::table('cart', fn(Blueprint $t) => $t->integer('store_id')->nullable()->after('id'));
            if (!Schema::hasColumn('cart', 'product_type')) Schema::table('cart', fn(Blueprint $t) => $t->string('product_type')->nullable()->after('product_variant_id'));
        }

        // ========== ORDER ITEMS ==========
        if (Schema::hasTable('order_items')) {
            if (!Schema::hasColumn('order_items', 'delivery_boy_id')) Schema::table('order_items', fn(Blueprint $t) => $t->integer('delivery_boy_id')->nullable()->after('seller_id'));
            if (!Schema::hasColumn('order_items', 'store_id')) Schema::table('order_items', fn(Blueprint $t) => $t->integer('store_id')->nullable()->after('delivery_boy_id'));
        }

        // ========== STORES ==========
        if (Schema::hasTable('stores')) {
            if (!Schema::hasColumn('stores', 'primary_color')) Schema::table('stores', fn(Blueprint $t) => $t->string('primary_color')->nullable()->after('is_default_store'));
            if (!Schema::hasColumn('stores', 'secondary_color')) Schema::table('stores', fn(Blueprint $t) => $t->string('secondary_color')->nullable()->after('primary_color'));
            if (!Schema::hasColumn('stores', 'hover_color')) Schema::table('stores', fn(Blueprint $t) => $t->string('hover_color')->nullable()->after('secondary_color'));
            if (!Schema::hasColumn('stores', 'active_color')) Schema::table('stores', fn(Blueprint $t) => $t->string('active_color')->nullable()->after('hover_color'));
            if (!Schema::hasColumn('stores', 'note_for_necessary_documents')) Schema::table('stores', fn(Blueprint $t) => $t->text('note_for_necessary_documents')->nullable()->after('active_color'));
            if (!Schema::hasColumn('stores', 'delivery_charge_type')) Schema::table('stores', fn(Blueprint $t) => $t->string('delivery_charge_type')->nullable()->after('note_for_necessary_documents'));
            if (!Schema::hasColumn('stores', 'delivery_charge_amount')) Schema::table('stores', fn(Blueprint $t) => $t->decimal('delivery_charge_amount', 10, 2)->default(0)->after('delivery_charge_type'));
            if (!Schema::hasColumn('stores', 'minimum_free_delivery_amount')) Schema::table('stores', fn(Blueprint $t) => $t->decimal('minimum_free_delivery_amount', 10, 2)->default(0)->after('delivery_charge_amount'));
            if (!Schema::hasColumn('stores', 'product_deliverability_type')) Schema::table('stores', fn(Blueprint $t) => $t->string('product_deliverability_type')->nullable()->after('minimum_free_delivery_amount'));
        }

        // ========== ORDERS ==========
        if (Schema::hasTable('orders')) {
            if (!Schema::hasColumn('orders', 'delivery_charge')) Schema::table('orders', fn(Blueprint $t) => $t->decimal('delivery_charge', 10, 2)->default(0)->after('payment_method'));
            if (!Schema::hasColumn('orders', 'promo_discount')) Schema::table('orders', fn(Blueprint $t) => $t->decimal('promo_discount', 10, 2)->default(0)->after('delivery_charge'));
            if (!Schema::hasColumn('orders', 'wallet_balance')) Schema::table('orders', fn(Blueprint $t) => $t->decimal('wallet_balance', 10, 2)->default(0)->after('promo_discount'));
        }

        // ========== USERS ==========
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'role')) Schema::table('users', fn(Blueprint $t) => $t->string('role')->nullable()->after('email'));
            if (!Schema::hasColumn('users', 'mobile')) Schema::table('users', fn(Blueprint $t) => $t->string('mobile')->nullable()->after('role'));
            if (!Schema::hasColumn('users', 'balance')) Schema::table('users', fn(Blueprint $t) => $t->decimal('balance', 10, 2)->default(0)->after('mobile'));
        }

        // ========== CATEGORIES ==========
        if (Schema::hasTable('categories')) {
            if (!Schema::hasColumn('categories', 'store_id')) Schema::table('categories', fn(Blueprint $t) => $t->integer('store_id')->nullable()->after('id'));
            if (!Schema::hasColumn('categories', 'row_order')) Schema::table('categories', fn(Blueprint $t) => $t->integer('row_order')->default(0)->after('status'));
        }
    }

    public function down(): void
    {
        // No down - this is a fix migration
    }
};
