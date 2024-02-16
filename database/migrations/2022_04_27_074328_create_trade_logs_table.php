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
        Schema::create('trade_logs', function (Blueprint $table) {
            $table->id();

            $table->string('trade_log_no')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('trade_no')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();

            $table->string('iagd_number')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('animal_no')->nullable();
            $table->string('cash_amount')->nullable();

            $table->string('role')->nullable();
            $table->string('accepted')->nullable();
            $table->string('expiration')->nullable();
            $table->string('log_status')->nullable();

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
        Schema::dropIfExists('trade_logs');
    }
};
