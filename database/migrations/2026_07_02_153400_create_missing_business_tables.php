<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // category_sliders
        if (!Schema::hasTable('category_sliders')) {
            Schema::create('category_sliders', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->integer('store_id')->nullable();
                $table->string('banner_image')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->string('style')->nullable();
                $table->text('category_ids')->nullable();
                $table->string('background_color')->nullable();
                $table->timestamps();
            });
        }

        // offer_sliders
        if (!Schema::hasTable('offer_sliders')) {
            Schema::create('offer_sliders', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->integer('store_id')->nullable();
                $table->string('banner_image')->nullable();
                $table->integer('offer_id')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->string('style')->nullable();
                $table->string('background_color')->nullable();
                $table->timestamps();
            });
        }

        // custom_fields
        if (!Schema::hasTable('custom_fields')) {
            Schema::create('custom_fields', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->string('validation')->nullable();
                $table->integer('store_id')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        // product_custom_field_values
        if (!Schema::hasTable('product_custom_field_values')) {
            Schema::create('product_custom_field_values', function (Blueprint $table) {
                $table->id();
                $table->integer('product_id')->nullable();
                $table->integer('custom_field_id')->nullable();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_custom_field_values');
        Schema::dropIfExists('custom_fields');
        Schema::dropIfExists('offer_sliders');
        Schema::dropIfExists('category_sliders');
    }
};
