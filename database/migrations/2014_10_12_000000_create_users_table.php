<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('username', 255)->nullable();
                $table->string('first_name', 255)->nullable();
                $table->string('last_name', 255)->nullable();
                $table->string('name', 255)->nullable();
                $table->string('email', 255)->nullable()->unique();
                $table->string('mobile', 255)->nullable();
                $table->string('country_code', 10)->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 255)->nullable();
                $table->string('role', 255)->nullable();
                $table->bigInteger('role_id')->nullable();
                $table->string('image', 255)->nullable();
                $table->string('disk', 255)->nullable();
                $table->text('address')->nullable();
                $table->string('area', 255)->nullable();
                $table->string('city', 255)->nullable();
                $table->string('state', 255)->nullable();
                $table->string('country', 255)->nullable();
                $table->string('pincode', 255)->nullable();
                $table->string('latitude', 255)->nullable();
                $table->string('longitude', 255)->nullable();
                $table->decimal('balance', 10, 2)->default(0);
                $table->string('referral_code', 255)->nullable();
                $table->string('friends_code', 255)->nullable();
                $table->integer('active')->default(1);
                $table->tinyInteger('active_status')->default(0);
                $table->tinyInteger('dark_mode')->default(0);
                $table->string('avatar', 255)->nullable();
                $table->string('messenger_color', 255)->nullable();
                $table->string('device_token', 255)->nullable();
                $table->text('fcm_token')->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
