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
            $table->fullText([
                'iagd_number',
                'old_iagd_number',
                'email_address',
                'first_name',
                'last_name',
                'middle_name',
                'contact_number',
                'referred_by',
            ],'full_text_query');
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
            $table->dropIndex('full_text_query');
        });
    }
};
