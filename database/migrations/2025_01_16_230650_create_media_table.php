<?php

use App\Models\Animal;
use App\Models\Location;
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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Animal::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Location::class)->constrained()->onDelete('cascade');
            $table->string('media_url');
            $table->string('thumbnail_url')->nullable();
            $table->enum('media_type', ['image', 'video','audio'])->index();
            $table->tinyInteger('rating')->nullable();
            $table->timestamp('date_taken');
            $table->string('caption')->nullable();
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');
            $table->enum('age', ['juvenile', 'adult', 'unknown'])->default('unknown');
            $table->json('metadata')->nullable();
            $table->string('hash', 64)->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table){
            $table->dropForeign(['animal_id']);
            $table->dropForeign(['location_id']);
        });
        Schema::dropIfExists('media');
    }
};
