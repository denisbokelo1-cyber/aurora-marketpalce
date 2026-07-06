<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveStatusToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'active_status')) {
                    $table->boolean('active_status')->default(0);
                }
            });
        } catch (\Exception $e) {
            // Table may not exist yet, skip gracefully
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active_status');
        });
    }
}
