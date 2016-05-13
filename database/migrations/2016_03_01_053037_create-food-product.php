<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foodProducts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fCode');
            $table->string('fName');
            $table->string('fManufacture');
            $table->integer('fVerify')->default(0);
            $table->integer('fView')->default(0);

            $table->float('weight')->default(0);
            $table->float('calories')->default(0);
            $table->float('totalFat')->default(0);
            $table->float('saturatedFat')->default(0);
            $table->float('transFat')->default(0);
            $table->float('cholesterol')->default(0);
            $table->float('sodium')->default(0);
            $table->float('totalCarbohydrates')->default(0);
            $table->float('dietaryFiber')->default(0);
            $table->float('sugar')->default(0);
            $table->float('protein')->default(0);
            $table->float('vitaminA')->default(0);
            $table->float('vitaminC')->default(0);
            $table->float('calcium')->default(0);
            $table->float('iron')->default(0);

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::drop('foodProducts');
    }
}
