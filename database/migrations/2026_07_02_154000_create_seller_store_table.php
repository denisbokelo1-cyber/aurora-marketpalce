<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('seller_store')) {
            Schema::create('seller_store', function (Blueprint $table) {
                $table->id();
                $table->integer('seller_id')->default(0);
                $table->integer('store_id')->default(0);
                $table->decimal('rating', 10, 2)->default(0);
                $table->integer('no_of_ratings')->default(0);
                $table->string('slug')->nullable();
                $table->string('logo')->nullable();
                $table->string('store_name')->nullable();
                $table->text('store_description')->nullable();
                $table->tinyInteger('deliverable_type')->default(0)->nullable();
                $table->string('deliverable_zones')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_store');
    }
};
