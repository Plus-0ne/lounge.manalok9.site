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
        Schema::create('members_ads', function (Blueprint $table) {
            $table->id();

            $table->string('member_ad_no')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('member_uuid')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('uuid')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();

            $table->text('title')->nullable();
            $table->longText('message')->nullable();

            $table->string('file_path')->nullable();

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
        Schema::dropIfExists('member_ads');
    }
};
