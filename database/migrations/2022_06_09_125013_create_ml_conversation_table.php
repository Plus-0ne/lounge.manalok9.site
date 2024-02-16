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
        Schema::create('ml_conversation', function (Blueprint $table) {
            $table->id();

            $table->string('room_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            $table->string('conversation_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            $table->string('sender_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('receiver_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            $table->text('message')->nullable();
            $table->tinyText('type')->nullable();
            $table->tinyInteger('status')->nullable();

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
        Schema::dropIfExists('ml_conversation');
    }
};
