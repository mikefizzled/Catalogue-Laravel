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
        Schema::create('conservation_lists', function (Blueprint $table) {
            $table->id();
            $table->string('short_name')->unique();
            $table->year('year');
            $table->string('full_name');
            $table->string('filename')->nullable();
            $table->text('authors')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conservation_lists');
    }
};
