<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ====== ADMIN CREDENTIALS ======
        $adminPhone = '0990905677';    // Format local congolais
        $adminPassword = 'Revival@26';
        echo "\n========================================\n";
        echo "  AURORA MARKETPLACE - ADMIN CREDENTIALS\n";
        echo "========================================\n";
        echo "  Téléphone : {$adminPhone}\n";
        echo "  Mot de passe : {$adminPassword}\n";
        echo "========================================\n\n";

        // ====== CREATE MISSING TABLES ======
        $this->createTables();

        // ====== ROLES ======
        if (DB::table('roles')->count() == 0) {
            DB::table('roles')->insert([
                ['name' => 'super_admin', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'admin', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'user', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'seller', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'delivery_boy', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'affiliate', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'editor', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        // ====== ADMIN USER ======
        if (DB::table('users')->count() == 0) {
            DB::table('users')->insert([
                'username' => 'Admin',
                'email' => 'admin@aurora.cd',
                'mobile' => '990905677',
                'country_code' => '+243',
                'password' => Hash::make($adminPassword),
                'role_id' => 1,
                'role' => 'super_admin',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ====== DEFAULT STORE ======
        if (DB::table('stores')->count() == 0) {
            DB::table('stores')->insert([
                'name' => 'AURORA Marketplace',
                'slug' => 'aurora-marketplace',
                'description' => 'Boutique officielle Aurora Marketplace - République Démocratique du Congo',
                'email' => 'contact@aurora.cd',
                'mobile' => '976543210',
                'country_code' => '+243',
                'address' => '63, Avenue de la Libération',
                'city' => 'Kinshasa',
                'state' => 'Lingwala',
                'country' => 'CD',
                'pincode' => '243',
                'status' => 1,
                'is_default_store' => 1,
                'is_approved' => 1,
                'free_shipping' => 0,
                'shipping_charge' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ====== SELLER DATA ======
        if (DB::table('seller_data')->count() == 0) {
            DB::table('seller_data')->insert([
                'name' => 'AURORA Marketplace',
                'email' => 'seller@aurora.cd',
                'mobile' => '976543210',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ====== SETTINGS ======
        if (DB::table('settings')->count() == 0) {
            DB::table('settings')->insert([
                ['variable' => 'system_settings', 'value' => '{"currency_setting":{"code":"CDF","symbol":"FC"}}', 'created_at' => $now, 'updated_at' => $now],
                ['variable' => 'web_settings', 'value' => '{"support_number":"+243860275282","support_email":"contact@aurora.cd","address":"63, Avenue de la Libération, Kinshasa","logo":"logo.png","site_name":"AURORA MARKETPLACE","site_title":"AURORA MARKETPLACE","app_short_description":"Achetez en toute confiance. Vendez en toute sérénité. - RDC"}', 'created_at' => $now, 'updated_at' => $now],
                ['variable' => 'terms_and_conditions', 'value' => '{"terms_and_conditions":"<p>Conditions G\u00e9n\u00e9rales<\/p>"}', 'created_at' => $now, 'updated_at' => $now],
                ['variable' => 'payment_method', 'value' => '{}', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        // ====== CURRENCIES ======
        if (DB::table('currencies')->count() == 0) {
            DB::table('currencies')->insert([
                ['code' => 'CDF', 'symbol' => 'FC', 'is_default' => 1, 'exchange_rate' => 1.0, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'USD', 'symbol' => '$', 'is_default' => 0, 'exchange_rate' => 2850.0, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        // ====== LANGUAGES ======
        if (DB::table('languages')->count() == 0) {
            DB::table('languages')->insert([
                ['code' => 'fr', 'name' => 'Français', 'is_default' => 1, 'is_rtl' => 0, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'en', 'name' => 'English', 'is_default' => 0, 'is_rtl' => 0, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'ln', 'name' => 'Lingala', 'is_default' => 0, 'is_rtl' => 0, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        echo "✅ Données initiales créées avec succès!\n";

        // ====== GENERATE README_ADMIN.md ======
        $readme = "# 🔐 Aurora Marketplace - Administrateur\n\n";
        $readme .= "## Identifiants de connexion\n\n";
        $readme .= "> ⚠️ Ce fichier contient des informations sensibles.\n";
        $readme .= "> **Ne jamais partager ces identifiants.**\n";
        $readme .= "> **À supprimer après configuration initiale.**\n\n";
        $readme .= "### Administrateur principal\n\n";
        $readme .= "| Champ | Valeur |\n";
        $readme .= "|-------|--------|\n";
        $readme .= "| Téléphone | `+243990905677` |\n";
        $readme .= "| Mot de passe | `{$adminPassword}` |\n\n";
        $readme .= "### Stockage sécurisé\n\n";
        $readme .= "Le mot de passe est stocké en base de données avec bcrypt.\n";
        $readme .= "Ne jamais modifier manuellement le hash en base de données.\n\n";
        $readme .= "### Sécurité\n\n";
        $readme .= "1. Changez ce mot de passe après la première connexion\n";
        $readme .= "2. Utilisez une connexion HTTPS en production\n";
        $readme .= "3. Activez l'authentification à deux facteurs si disponible\n";
        $readme .= "4. Ne partagez jamais ces identifiants par email ou messagerie\n\n";
        $readme .= "### En cas d'urgence\n\n";
        $readme .= "Pour réinitialiser le mot de passe administrateur :\n\n";
        $readme .= "```bash\n";
        $readme .= "php artisan tinker\n";
        $readme .= "\$user = App\\Models\\User::where('mobile', '976543210')->first();\n";
        $readme .= "\$user->password = Hash::make('nouveau-mot-de-passe');\n";
        $readme .= "\$user->save();\n";
        $readme .= "```\n\n";
        $readme .= "---\n\n";
        $readme .= "*Document généré automatiquement le " . $now->format('d/m/Y à H:i') . "*\n";

        file_put_contents(__DIR__ . '/../../README_ADMIN.md', $readme);
        echo "✅ Fichier README_ADMIN.md généré.\n";
    }

    private function createTables()
    {
        $tables = [
            'settings' => "CREATE TABLE IF NOT EXISTS `settings` (
                `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                `variable` varchar(255) NOT NULL,
                `value` longtext,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

            'currencies' => "CREATE TABLE IF NOT EXISTS `currencies` (
                `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                `code` varchar(10) NOT NULL,
                `symbol` varchar(10) DEFAULT NULL,
                `is_default` tinyint(1) NOT NULL DEFAULT '0',
                `exchange_rate` decimal(10,4) DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

            'languages' => "CREATE TABLE IF NOT EXISTS `languages` (
                `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                `code` varchar(10) NOT NULL,
                `name` varchar(255) DEFAULT NULL,
                `is_default` tinyint(1) NOT NULL DEFAULT '0',
                `is_rtl` tinyint(1) NOT NULL DEFAULT '0',
                `status` tinyint(1) NOT NULL DEFAULT '1',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

            'roles' => "CREATE TABLE IF NOT EXISTS `roles` (
                `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `guard_name` varchar(255) NOT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

            'stores' => "CREATE TABLE IF NOT EXISTS `stores` (
                `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` varchar(255) DEFAULT NULL,
                `slug` varchar(255) DEFAULT NULL,
                `description` longtext,
                `email` varchar(255) DEFAULT NULL,
                `mobile` varchar(255) DEFAULT NULL,
                `country_code` varchar(10) DEFAULT NULL,
                `address` text,
                `city` varchar(255) DEFAULT NULL,
                `state` varchar(255) DEFAULT NULL,
                `country` varchar(255) DEFAULT NULL,
                `pincode` varchar(255) DEFAULT NULL,
                `latitude` varchar(255) DEFAULT NULL,
                `longitude` varchar(255) DEFAULT NULL,
                `logo` varchar(255) DEFAULT NULL,
                `thumbnail` varchar(255) DEFAULT NULL,
                `banner` varchar(255) DEFAULT NULL,
                `user_id` bigint UNSIGNED DEFAULT NULL,
                `seller_id` bigint UNSIGNED DEFAULT NULL,
                `status` tinyint(1) NOT NULL DEFAULT '1',
                `is_default_store` tinyint(1) NOT NULL DEFAULT '0',
                `commission` decimal(10,2) DEFAULT '0.00',
                `min_item_free_shipping` decimal(10,2) DEFAULT NULL,
                `shipping_charge` decimal(10,2) DEFAULT '0.00',
                `free_shipping` tinyint(1) NOT NULL DEFAULT '0',
                `is_approved` tinyint(1) NOT NULL DEFAULT '1',
                `primary_color` varchar(20) DEFAULT '#F97316',
                `secondary_color` varchar(20) DEFAULT '#1E293B',
                `active_color` varchar(20) DEFAULT '#F97316',
                `hover_color` varchar(20) DEFAULT '#EA580C',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

            'seller_data' => "CREATE TABLE IF NOT EXISTS `seller_data` (
                `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` varchar(255) DEFAULT NULL,
                `email` varchar(255) DEFAULT NULL,
                `mobile` varchar(255) DEFAULT NULL,
                `status` tinyint(1) NOT NULL DEFAULT '1',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
        ];

        foreach ($tables as $name => $sql) {
            if (!Schema::hasTable($name)) {
                DB::statement($sql);
                echo "  - Table `{$name}` created\n";
            }
        }
    }
}
