<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_generations', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('pet_id')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();

            $table->string('pet_type')->nullable();

            $table->string('pair_no')->nullable();
            $table->string('sire_name')->nullable();
            $table->string('sire_breed')->nullable();
            $table->string('dam_name')->nullable();
            $table->string('dam_breed')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pet_generations');
    }
};
