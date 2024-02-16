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
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('user_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('product_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('quantity')->nullable();
            $table->string('status')->nullable(); // 1 = in cart ; 2 = ordering ; 3 = verified order ; 4 = packing; 5 = delivering ; 6 = received ; 7 = cancelled
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
        Schema::dropIfExists('product_orders');
    }
};
