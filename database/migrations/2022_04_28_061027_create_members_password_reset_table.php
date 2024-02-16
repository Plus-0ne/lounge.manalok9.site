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
        Schema::create('members_password_reset', function (Blueprint $table) {

            Schema::dropIfExists('members_password_reset');

            $table->id();
            $table->string('email_address')->nullable();
            $table->string('token')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('expiration')->nullable();
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
        Schema::dropIfExists('members_password_reset');
    }
};
