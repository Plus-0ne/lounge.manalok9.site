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
        Schema::create('service_enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('user_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('petName')->nullable();
            $table->string('petBreed')->nullable();
            $table->string('petColor')->nullable();
            $table->string('petAge')->nullable();
            $table->string('petGender')->nullable();

            $table->string('petOwner')->nullable();
            $table->text('currentAddress')->nullable();
            $table->string('contactNumber')->nullable();
            $table->string('mobileNumber')->nullable();
            $table->string('emailAddress')->nullable();
            $table->text('fbAccountLink')->nullable();
            $table->text('personalBelongings')->nullable();

            $table->text('textAreaDogToClass')->nullable();
            $table->text('textAreaWhatToAccomplish')->nullable();
            $table->text('textAreaWhereAboutUs')->nullable();

            $table->tinyInteger('ehrlichiosis')->nullable();
            $table->tinyInteger('liverProblem')->nullable();
            $table->tinyInteger('kidneyProblem')->nullable();
            $table->tinyInteger('fracture')->nullable();
            $table->tinyInteger('hipDysplasia')->nullable();
            $table->tinyInteger('allergy')->nullable();
            $table->tinyInteger('eyeIrritation')->nullable();
            $table->tinyInteger('skinProblem')->nullable();
            $table->tinyInteger('undergoneOperation')->nullable();

            $table->tinyInteger('biteIncendent')->nullable(); // 1 = true or 0 = false
            $table->string('biteIncendentSelected')->nullable();

            $table->tinyInteger('otherHealthProblem')->nullable(); // 1 = true or 0 = false
            $table->text('textAreaOtherHealthProblem')->nullable();

            $table->string('healthRecord')->nullable(); // Upladed urls
            $table->string('laboratoryResult')->nullable(); // Upladed urls

            $table->string('status')->nullable();
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
        Schema::dropIfExists('service_enrollments');
    }
};
