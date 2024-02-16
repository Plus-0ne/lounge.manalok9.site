<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('members_documents');

        Schema::create('members_documents', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('members_file')->nullable();
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
        Schema::dropIfExists('members_documents');
    }
}
