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
        Schema::create('dealers_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('dealers_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('filename')->nullable();
            $table->string('type')->nullable();
            $table->string('path')->nullable();
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
        Schema::dropIfExists('dealers_attachments');
    }
};
