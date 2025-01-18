<?php

use App\Models\Family;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genera', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Family::class)->constrained()->onDelete('cascade');
            $table->string('genus_name');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();

            // Unique composite key to ensure each genus is unique within a family
            $table->unique(['family_id', 'genus_name'], 'family_genus_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('genera', function (Blueprint $table){
            $table->dropForeign(['family_id']);
        });
        Schema::dropIfExists('genera');
    }
};
