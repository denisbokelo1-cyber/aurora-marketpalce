<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Approbation
            if (!Schema::hasColumn('users', 'is_approved')) {
                $table->tinyInteger('is_approved')->default(0)->comment('0=pending,1=approved,2=rejected');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->tinyInteger('status')->default(1)->comment('0=inactive,1=active');
            }
            if (!Schema::hasColumn('users', 'bonus_type')) {
                $table->string('bonus_type', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'bonus')) {
                $table->decimal('bonus', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('users', 'front_licence_image')) {
                $table->string('front_licence_image', 255)->nullable();
            }
            if (!Schema::hasColumn('users', 'back_licence_image')) {
                $table->string('back_licence_image', 255)->nullable();
            }
            if (!Schema::hasColumn('users', 'serviceable_zones')) {
                $table->text('serviceable_zones')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_available')) {
                $table->tinyInteger('is_available')->default(1);
            }
            if (!Schema::hasColumn('users', 'cash_received')) {
                $table->decimal('cash_received', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('users', 'is_notification_on')) {
                $table->tinyInteger('is_notification_on')->default(1);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'is_approved', 'status', 'bonus_type', 'bonus',
                'front_licence_image', 'back_licence_image',
                'serviceable_zones', 'is_available', 'cash_received',
                'is_notification_on'
            ];
            foreach ($columns as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
