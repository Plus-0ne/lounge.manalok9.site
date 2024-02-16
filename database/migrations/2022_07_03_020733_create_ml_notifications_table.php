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
        Schema::create('ml_notifications', function (Blueprint $table) {
            $table->id();

            $table->string('notification_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            /* Notification from user */
            $table->string('from_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            /* Notification to user */
            $table->string('to_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');


            /* Reaction , Comment , Follow */
            $table->string('type')->nullable();

            /*
                Content
                Check type then get uuid from that type to get notification content
            */
            $table->string('content')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            /* Status read or unread */
            $table->string('status')->nullable();
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
        Schema::dropIfExists('ml_notifications');
    }
};
