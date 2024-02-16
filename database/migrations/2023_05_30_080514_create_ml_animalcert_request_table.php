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
        Schema::create('ml_animalcert_request', function (Blueprint $table) {

            /* Default id */
            $table->id();

            /* Request uuid */
            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            /* Request from user uuid */
            $table->string('user_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            /* Anime request for certification */
            $table->string('animal_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            $table->tinyInteger('include_pedigree_cert');

            $table->string('sire_iagd_num');
            $table->string('sire_name');
            $table->string('sire_breed');

            $table->string('dam_iagd_num');
            $table->string('dam_name');
            $table->string('dam_breed');

            $table->tinyInteger('status');

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
        Schema::dropIfExists('ml_animalcert_request');
    }
};
