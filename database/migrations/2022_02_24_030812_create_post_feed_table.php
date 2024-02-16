<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostFeedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('post_feed');

        Schema::create('post_feed', function (Blueprint $table) {
            $table->id()->index();
            $table->string('post_id')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('type')->nullable();

            $table->string('uuid')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->longText('post_message')->nullable();
            $table->text('date')->nullable();
            $table->text('time')->nullable();
            $table->string('status')->nullable();
            $table->string('visibility')->nullable();
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
        Schema::dropIfExists('post_feed');
    }
}
