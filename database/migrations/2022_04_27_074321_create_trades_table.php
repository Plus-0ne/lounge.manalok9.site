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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();

            $table->string('trade_no')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('trade_log_no')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('description')->nullable();
            
            $table->string('poster_iagd_number')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('poster_animal_no')->nullable();
            $table->string('poster_cash_amount')->nullable();

            $table->string('requester_iagd_number')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('requester_animal_no')->nullable();
            $table->string('requester_cash_amount')->nullable();

            $table->string('trade_status')->nullable();

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
        Schema::dropIfExists('trades');
    }
};
