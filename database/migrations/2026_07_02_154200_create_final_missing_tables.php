<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // parcel_items
        if (!Schema::hasTable('parcel_items')) {
            Schema::create('parcel_items', function (Blueprint $table) {
                $table->id();
                $table->integer('parcel_id')->default(0);
                $table->integer('order_item_id')->default(0);
                $table->integer('product_variant_id')->default(0);
                $table->decimal('unit_price', 10, 2)->default(0);
                $table->integer('quantity')->default(1);
                $table->timestamps();
            });
        }

        // search_history
        if (!Schema::hasTable('search_history')) {
            Schema::create('search_history', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->default(0);
                $table->string('keyword')->nullable();
                $table->timestamps();
            });
        }

        // seller_commissions
        if (!Schema::hasTable('seller_commissions')) {
            Schema::create('seller_commissions', function (Blueprint $table) {
                $table->id();
                $table->integer('seller_id')->default(0);
                $table->integer('category_id')->default(0);
                $table->decimal('commission', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        // storage_types
        if (!Schema::hasTable('storage_types')) {
            Schema::create('storage_types', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        // Missing columns
        if (Schema::hasTable('addresses') && !Schema::hasColumn('addresses', 'user_id')) {
            Schema::table('addresses', fn(Blueprint $t) => $t->integer('user_id')->default(0)->after('id'));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('parcel_items');
        Schema::dropIfExists('search_history');
        Schema::dropIfExists('seller_commissions');
        Schema::dropIfExists('storage_types');
    }
};
