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
        Schema::create('test_animals', function (Blueprint $table) {
            $table->id();

            $table->string('owner_iagd_number')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            $table->string('rabbit_name')->nullable();
            $table->string('eye_color')->nullable();
            $table->text('rabbit_color')->nullable();
            $table->text('markings')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('location_details')->nullable();
            $table->string('gender')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('owner')->nullable();
            $table->string('rabbit_no')->nullable();
            $table->string('age')->nullable();
            $table->string('name_of_sire')->nullable();
            $table->string('name_of_dam')->nullable();
            $table->string('breed')->nullable();

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
        Schema::dropIfExists('test_animals');
    }
};
