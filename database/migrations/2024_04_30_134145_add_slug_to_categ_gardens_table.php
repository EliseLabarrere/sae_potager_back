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
        Schema::table('categ_gardens', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->string('slug');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categ_gardens', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
