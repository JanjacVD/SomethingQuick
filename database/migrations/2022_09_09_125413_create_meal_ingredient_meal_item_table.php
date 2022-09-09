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
        Schema::create('meal_ingredient_meal_item', function (Blueprint $table) {
            $table->unsignedBigInteger('meal_item_id')->index();
            $table->foreign('meal_item_id')->references('id')->on('meal_items')->onDelete('cascade');

            $table->unsignedBigInteger('meal_ingredient_id')->index();
            $table->foreign('meal_ingredient_id')->references('id')->on('meal_ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_ingredient_meal_item');
    }
};
