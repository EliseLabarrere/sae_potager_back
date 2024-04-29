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
        Schema::create('plant_tip', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Plant::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Tip::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_tip');
    }
};