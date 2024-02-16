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
            $table->string('old_iagd_number')->nullable()->after('iagd_number');
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
            $table->dropColumn('old_iagd_number');
        });
    }
};
