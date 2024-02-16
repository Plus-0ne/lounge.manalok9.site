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
        Schema::dropIfExists('post_comments');

        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->string('post_id')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('uuid')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->text('comment')->nullable();
            $table->text('mentions')->nullable();
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
        Schema::dropIfExists('post_comments');
    }
};
