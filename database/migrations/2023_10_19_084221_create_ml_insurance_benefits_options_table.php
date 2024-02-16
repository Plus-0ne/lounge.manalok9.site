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
        Schema::create('ml_insurance_benefits_options', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->text('title')->nullable();
            $table->string('added_by')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->string('updated_by')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->softDeletes();
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
        Schema::dropIfExists('ml_insurance_benefits_options');
    }
};
