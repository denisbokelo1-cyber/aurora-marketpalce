<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('users', function ($table) {
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
