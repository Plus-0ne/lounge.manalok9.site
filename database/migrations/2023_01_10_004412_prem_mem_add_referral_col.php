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
        Schema::table('ml_iagd_details', function (Blueprint $table) {
            $table->string('referral_code')->nullable()->after('fb_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ml_iagd_details', function (Blueprint $table) {
            $table->dropColumn('referral_code');
        });
    }
};
