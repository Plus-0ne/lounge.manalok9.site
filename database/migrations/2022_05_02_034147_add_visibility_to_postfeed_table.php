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
        if (!Schema::hasColumn('post_feed', 'visibility')) {
            Schema::table('post_feed', function (Blueprint $table) {
                $table->string('visibility')->after('status')->nullable();
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
        Schema::table('post_feed', function (Blueprint $table) {
             $table->dropColumn('visibility');
        });
    }
};
