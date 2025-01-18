<?php

use App\Models\Animal;
use App\Models\ConservationList;
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
        Schema::create('conservation_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Animal::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(ConservationList::class)->constrained()->onDelete('cascade');
            $table->enum('status', ['green', 'amber', 'red', 'former breeder', 'not assessed'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conservation_statuses', function (Blueprint $table){
            $table->dropForeign(['animal_id']);
            $table->dropForeign(['conservation_list_id']);
        });
        Schema::dropIfExists('conservation_statuses');
    }
};
