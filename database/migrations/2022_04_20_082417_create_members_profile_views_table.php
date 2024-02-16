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
        Schema::dropIfExists('members_profile_views');
        Schema::create('members_profile_views', function (Blueprint $table) {
            $table->id();
            $table->string('profile_uuid')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->string('visitor_uuid')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
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
        Schema::dropIfExists('members_profile_views');
    }
};
