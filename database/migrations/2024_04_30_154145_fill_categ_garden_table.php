<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('categ_gardens')->insert([
            [
                'slug' => "none",
                'name' => "Aucun type de jardin spécifié",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'slug' => "interior_shadow",
                'name' => "Potager ombragé en intérieur",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'interior_semishadow',
                'name' => "Potager partiellement ombragé en intérieur",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'interior_sun',
                'name' => "Potager ensoleillé en intérieur",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'slug' => "window_shadow",
                'name' => "Potager ombragé sur un rebord de fenêtre",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'window_semishadow',
                'name' => "Potager partiellement ombragé sur un rebord de fenêtre",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'window_sun',
                'name' => "Potager ensoleillé sur un rebord de fenêtre",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'slug' => "balcony_shadow",
                'name' => "Potager ombragé sur balcon",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'balcony_semishadow',
                'name' => "Potager partiellement ombragé sur balcon",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'balcony_sun',
                'name' => "Potager ensoleillé sur balcon",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'slug' => "jardin_shadow",
                'name' => "Jardin ombragé",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'jardin_semishadow',
                'name' => "Jardin partiellement",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'jardin_sun',
                'name' => "Jardin ensoleillé",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'slug' => "greenhouse_shadow",
                'name' => "Potager ombragé sous serre",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'greenhouse_semishadow',
                'name' => "Potager partiellement sous serre",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'greenhouse_sun',
                'name' => "Potager ensoleillé sous serre",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer toutes les lignes de la table
        DB::table('categ_gardens')->truncate();

        // Réinitialiser la valeur d'auto-incrémentation à 1
        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');
    }
};
