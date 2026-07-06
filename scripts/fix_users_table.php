<?php
// ============================================
// FIX: Ajouter la colonne 'role' manquante
// Créer/réinitialiser l'admin
// ============================================
// Exécuter SUR LE SERVEUR :
//   cd /var/www/aurora-marketpalce && php /tmp/fix_users_table.php
// ============================================

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

echo "========================================\n";
echo " CORRECTION BASE DE DONNÉES\n";
echo "========================================\n\n";

// 1. Vider les caches
echo "1️⃣ Vidange des caches...\n";
Artisan::call('view:clear');
echo "   ✅ view:clear\n";
Artisan::call('cache:clear'); 
echo "   ✅ cache:clear\n";
Artisan::call('config:clear');
echo "   ✅ config:clear\n";

// 2. Vérifier si la colonne 'role' existe
echo "\n2️⃣ Vérification de la colonne 'role'...\n";
$hasRoleColumn = false;
try {
    $columns = DB::select('SHOW COLUMNS FROM users');
    foreach ($columns as $col) {
        if ($col->Field === 'role') {
            $hasRoleColumn = true;
            break;
        }
    }
} catch (Exception $e) {
    echo "   ⚠️  Impossible de vérifier: " . $e->getMessage() . "\n";
}

if (!$hasRoleColumn) {
    echo "   ❌ Colonne 'role' manquante. Ajout en cours...\n";
    try {
        DB::statement('ALTER TABLE users ADD COLUMN role VARCHAR(255) NULL AFTER role_id');
        echo "   ✅ Colonne 'role' ajoutée avec succès\n";
    } catch (Exception $e) {
        echo "   ⚠️  Erreur: " . $e->getMessage() . "\n";
        echo "   Tentative avec requête directe...\n";
        try {
            DB::unprepared('ALTER TABLE users ADD COLUMN IF NOT EXISTS role VARCHAR(255) NULL AFTER role_id');
        } catch (Exception $e2) {
            echo "   ⚠️  " . $e2->getMessage() . "\n";
        }
    }
} else {
    echo "   ✅ Colonne 'role' existe déjà\n";
}

// 3. Créer/réinitialiser l'admin SANS le champ 'role'
echo "\n3️⃣ Création/réinitialisation de l'admin...\n";

$mobile = '990905677';
$existing = DB::table('users')->where('mobile', $mobile)->first();

if ($existing) {
    DB::table('users')->where('id', $existing->id)->update([
        'password' => Hash::make('Revival@26'),
        'country_code' => '243',
        'active' => 1,
        'updated_at' => now(),
    ]);
    echo "   ✅ Admin {$existing->username} (id={$existing->id}) réinitialisé\n";
} else {
    try {
        $id = DB::table('users')->insertGetId([
            'username' => 'AdminPrincipal',
            'email' => 'admin@aurora.cd',
            'mobile' => '990905677',
            'country_code' => '243',
            'password' => Hash::make('Revival@26'),
            'role_id' => 1,
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "   ✅ Admin créé (id={$id})\n";
    } catch (Exception $e) {
        echo "   ❌ Erreur: " . $e->getMessage() . "\n";
        exit(1);
    }
}

// 4. Vérification finale
echo "\n4️⃣ Vérification finale...\n";
$check = DB::table('users')
    ->select('id', 'username', 'mobile', 'country_code', 'role_id', 'active')
    ->where('mobile', '990905677')
    ->first();

if ($check) {
    echo "   ✅ Utilisateur trouvé:\n";
    echo "      id: {$check->id}\n";
    echo "      username: {$check->username}\n";
    echo "      mobile: {$check->mobile}\n";
    echo "      country_code: {$check->country_code}\n";
    echo "      active: {$check->active}\n";
    
    $hashOk = Hash::check('Revival@26', DB::table('users')->where('id', $check->id)->value('password'));
    echo $hashOk ? "   ✅ Mot de passe valide\n" : "   ❌ Mot de passe invalide\n";
}

echo "\n========================================\n";
echo " ✅ CORRECTION TERMINÉE\n";
echo "========================================\n";
echo " Connectez-vous maintenant:\n";
echo " 📞 990905677 (sans +243)\n";
echo " 🔑 Revival@26\n";
echo " 🌐 /admin/login\n";
echo "========================================\n";
