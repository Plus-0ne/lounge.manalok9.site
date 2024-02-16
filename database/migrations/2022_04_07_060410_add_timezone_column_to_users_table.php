<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTimezoneColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('iagd_members', 'timezone')) {
            Schema::table('iagd_members', function (Blueprint $table) {
                $table->string('timezone')->after('remember_token')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iagd_members', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });
    }
}
