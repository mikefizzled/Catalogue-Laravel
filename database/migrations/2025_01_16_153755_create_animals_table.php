<?php

use App\Models\Genus;
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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Genus::class)->constrained()->onDelete('cascade');
            $table->string('common_name')->index();
            $table->string('scientific_name')->unique();
            $table->string('ebird_species_code')->nullable()->unique();
            $table->string('slug')->unique();
            $table->string('thumbnail_url')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table){
            //$table->dropForeign(['genus_id']);
        });
        Schema::dropIfExists('animals');
    }
};
