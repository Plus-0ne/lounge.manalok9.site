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
            $table->string('is_premium')->nullable()->after('is_email_verified')->default('0')->comment('0=not;1=premium;');
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
            $table->dropColumn('is_premium');
        });
    }
};
