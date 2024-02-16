<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id()->index();

            /* Admin uuid */
            $table->string('admin_id')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();

            /* Admin user account uuid */
            $table->string('user_uuid')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();

            /* Admin email address */
            $table->string('email_address')->nullable()->unique();

            /* Admin password */
            $table->string('password')->nullable();

            /* Admin department */
            $table->string('department')->nullable();

            /* Admin position */
            $table->string('position')->nullable();

            /* Admin roles */
            $table->string('roles')->nullable();

            /* Person added this admin - fill admin uuid to get admin account details */
            $table->string('added_by')->nullable();

            /* Remember token */
            $table->rememberToken();

            /* Enable soft deletes */
            $table->softDeletes();

            /* Timestamp */
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
        Schema::dropIfExists('admins');
    }
}
