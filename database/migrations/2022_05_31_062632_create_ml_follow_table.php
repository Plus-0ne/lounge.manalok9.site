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
        Schema::create('ml_follow', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('follow_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('room_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            $table->tinyText('status')->nullable();
            $table->tinyText('last_message_at')->nullable();

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
        Schema::dropIfExists('ml_follow');
    }
};
