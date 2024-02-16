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
        Schema::table('pet_images', function (Blueprint $table) {
            $table->string('pet_uuid')->nullable()->after('pet_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pet_images', function (Blueprint $table) {
            $table->dropColumn('pet_uuid');
        });
    }
};
