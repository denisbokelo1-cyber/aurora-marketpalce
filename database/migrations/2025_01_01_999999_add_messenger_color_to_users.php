<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessengerColorToUsers extends Migration
{
    public function up()
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'messenger_color')) {
                    $table->string('messenger_color')->default('#2180f3');
                }
            });
        } catch (\Exception $e) {
            // Skip gracefully if table doesn't exist yet
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('messenger_color');
        });
    }
}
