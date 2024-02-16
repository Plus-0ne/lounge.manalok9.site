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
        Schema::create('insurance_order', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('user_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('insurance_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('order_id')->nullable();
            $table->string('price')->nullable();
            $table->tinyInteger('status')->nullable(); // 0 = cart : 1 = ordered : 2 = verified : 3 active or approved
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
        Schema::dropIfExists('insurance_order');
    }
};
