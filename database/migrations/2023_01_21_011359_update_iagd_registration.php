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
            $table->string('membership_package')->nullable()->after('fb_url');
            $table->string('referred_by')->nullable()->after('referral_code');
            $table->string('premium_registration_comission_uuid')->nullable()->after('referred_by');
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
            $table->dropColumn('membership_package');
            $table->dropColumn('referred_by');
        });
    }
};
