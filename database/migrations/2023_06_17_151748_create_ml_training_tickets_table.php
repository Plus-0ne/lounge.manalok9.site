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
        Schema::create('ml_training_tickets', function (Blueprint $table) {
            /* Row id */
            $table->id();
            /* Request uuid */
            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            /* Request from user uuid */
            $table->string('user_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            $table->string('updated_contact');
            $table->string('facebook_link');

            $table->string('status');

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
        Schema::dropIfExists('ml_training_tickets');
    }
};
