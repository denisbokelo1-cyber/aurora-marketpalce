<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });

        // Créer le compte admin s'il n'existe pas déjà
        $adminExists = DB::table('users')->where('mobile', '990905677')->exists();

        if (!$adminExists) {
            $adminId = DB::table('users')->insertGetId([
                'username' => 'AdminPrincipal',
                'mobile' => '990905677',
                'country_code' => '243',
                'email' => 'admin@aurora.local',
                'password' => Hash::make('Revival@26'),
                'role_id' => 1,
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Assigner le rôle super_admin via Spatie si la table model_has_roles existe
            if (Schema::hasTable('model_has_roles')) {
                $superAdminRole = DB::table('roles')->where('name', 'super_admin')->first();
                if ($superAdminRole) {
                    DB::table('model_has_roles')->updateOrInsert([
                        'role_id' => $superAdminRole->id,
                        'model_type' => 'App\Models\User',
                        'model_id' => $adminId,
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });

        // Supprimer le compte admin créé par cette migration
        DB::table('users')->where('email', 'admin@aurora.local')->delete();
    }
};
