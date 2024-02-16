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
        Schema::create('ml_insurance', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');

            $table->string('plan_type')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->string('price')->nullable();
            $table->string('coverage_period')->nullable();
            $table->string('coverage_type')->nullable();

            $table->string('package_type')->nullable();

            $table->tinyInteger('available_discount')->nullable(); // 1 or 0
            $table->tinyInteger('status')->nullable();
            $table->string('image_path')->nullable();
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
        Schema::dropIfExists('ml_insurance');
    }
};
