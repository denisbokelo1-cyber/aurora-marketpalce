<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // combo_products
        if (!Schema::hasTable('combo_products')) {
            Schema::create('combo_products', function (Blueprint $table) {
                $table->id();
                $table->integer('seller_id')->default(0);
                $table->integer('store_id')->default(0);
                $table->string('title')->nullable();
                $table->text('short_description')->nullable();
                $table->string('slug')->nullable();
                $table->text('image')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->decimal('discounted_price', 10, 2)->default(0);
                $table->tinyInteger('status')->default(1);
                $table->string('type')->nullable();
                $table->string('product_type')->nullable();
                $table->decimal('tax', 10, 2)->default(0);
                $table->string('tax_type')->nullable();
                $table->timestamps();
            });
        }

        // product_faqs
        if (!Schema::hasTable('product_faqs')) {
            Schema::create('product_faqs', function (Blueprint $table) {
                $table->id();
                $table->integer('product_id')->default(0);
                $table->integer('user_id')->default(0);
                $table->text('question')->nullable();
                $table->text('answer')->nullable();
                $table->integer('answered_by')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        // combo_product_ratings is already created by fix_all_tables
        // delivery_boys already created
        // zones already created
    }

    public function down(): void
    {
        Schema::dropIfExists('combo_products');
        Schema::dropIfExists('product_faqs');
    }
};
