<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'google_id')) {
                    $table->string('google_id')->nullable()->after('email');
                }
            });
        } catch (\Exception $e) {
            // Skip
        }
    }

    public function down(): void
    {
        //
    }
};
