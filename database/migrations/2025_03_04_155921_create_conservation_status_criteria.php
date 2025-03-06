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
        Schema::create('conservation_status_criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conservation_status_id')
                ->constrained('conservation_statuses')
                ->onDelete('cascade'); 

            $table->foreignId('bocc_criteria_id')
                ->constrained('bocc_criteria_definitions')
                ->onDelete('cascade'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conservation_status_criteria');
    }
};
