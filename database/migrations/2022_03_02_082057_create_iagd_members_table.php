<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIagdMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iagd_members', function (Blueprint $table) {
            /* INDEX COLUMN */
            $table->id();
            $table->string('uuid')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();

            /* AUTHENTICATION */
            $table->string('iagd_number')->nullable();
            $table->string('email_address')->nullable();
            $table->string('password')->nullable();

            /* IS GOOGLE REGISTRATION */
            $table->string('isGoogle')->nullable();

            /* BASIC INFORMATION */
            $table->string('profile_image')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();

            /* STATUS */
            $table->string('is_email_verified')->nullable();

            $table->string('timezone')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('iagd_members');
    }
}
