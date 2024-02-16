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
        Schema::create('user_drop_winners', function (Blueprint $table) {
            $table->id();
            $table->string('U_id');
            $table->string('Quantity_ordered');
            $table->string('Products_Name');
            $table->string('Description');
            $table->string('Price_PerItem');
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
        Schema::dropIfExists('user_drop_winners');
    }
};
