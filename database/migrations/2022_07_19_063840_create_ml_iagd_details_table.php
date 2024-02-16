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
        Schema::create('ml_iagd_details', function (Blueprint $table) {
            $table->id();
            $table->string('registration_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('user_uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('iagd_number')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('middle_initial')->nullable();

            $table->string('email_address')->nullable();
            $table->string('contact_number')->nullable();

            $table->text('address')->nullable();
            $table->text('shipping_address')->nullable();

            $table->tinyText('nearest_lbc_branch')->nullable();
            $table->tinyText('name_on_card')->nullable();
            $table->tinyText('fb_url')->nullable();

            $table->string('status')->nullable();

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
        Schema::dropIfExists('ml_iagd_details');
    }
};
