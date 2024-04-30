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
                'slug' => "interior_shadow",
                'name' => "Potager ombragé en intérieur",
            ],
            [
                'slug' => 'interior_semishadow',
                'name' => "Potager partiellement ombragé en intérieur",
            ],
            [
                'slug' => 'interior_sun',
                'name' => "Potager ensoleillé en intérieur",
            ],

            [
                'slug' => "window_shadow",
                'name' => "Potager ombragé sur un rebord de fenêtre",
            ],
            [
                'slug' => 'window_semishadow',
                'name' => "Potager partiellement ombragé sur un rebord de fenêtre",
            ],
            [
                'slug' => 'window_sun',
                'name' => "Potager ensoleillé sur un rebord de fenêtre",
            ],

            [
                'slug' => "balcony_shadow",
                'name' => "Potager ombragé sur balcon",
            ],
            [
                'slug' => 'balcony_semishadow',
                'name' => "Potager partiellement sur balcon",
            ],
            [
                'slug' => 'balcony_sun',
                'name' => "Potager ensoleillé sur balcon",
            ],

            [
                'slug' => "jardin_shadow",
                'name' => "Jardin ombragé",
            ],
            [
                'slug' => 'jardin_semishadow',
                'name' => "Jardin partiellement",
            ],
            [
                'slug' => 'jardin_sun',
                'name' => "Jardin ensoleillé",
            ],

            [
                'slug' => "greenhouse_shadow",
                'name' => "Potager ombragé sous serre",
            ],
            [
                'slug' => 'greenhouse_semishadow',
                'name' => "Potager partiellement sous serre",
            ],
            [
                'slug' => 'greenhouse_sun',
                'name' => "Potager ensoleillé sous serre",
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
