<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plant_user', function (Blueprint $table) {
            $table->after('nickname', function ($table) {
                $table->integer('number_of_plant')->default(1);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plant_user', function (Blueprint $table) {
            $table->dropColumn('number_of_plant');
        });
    }
};
