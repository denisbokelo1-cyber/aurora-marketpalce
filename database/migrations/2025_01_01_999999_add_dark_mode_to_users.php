<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDarkModeToUsers extends Migration
{
    public function up()
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'dark_mode')) {
                    $table->boolean('dark_mode')->default(0);
                }
            });
        } catch (\Exception $e) {
            // Skip gracefully if table doesn't exist yet
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('dark_mode');
        });
    }
}
