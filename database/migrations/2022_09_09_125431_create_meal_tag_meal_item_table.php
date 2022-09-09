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
        Schema::create('meal_tag_meal_item', function (Blueprint $table) {
            $table->unsignedBigInteger('meal_item_id')->index();
            $table->foreign('meal_item_id')->references('id')->on('meal_items')->onDelete('cascade');

            $table->unsignedBigInteger('meal_tag_id')->index();
            $table->foreign('meal_tag_id')->references('id')->on('meal_tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_tag_meal_item');
    }
};
