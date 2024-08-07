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
        Schema::table('iagd_members', function (Blueprint $table) {
            $table->fullText(['first_name', 'last_name', 'middle_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iagd_members', function (Blueprint $table) {
            $table->dropFullText(['first_name', 'last_name', 'middle_name']);
        });
    }
};
