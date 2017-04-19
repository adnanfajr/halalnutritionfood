<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManufacture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufactures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('foodProduct_manufacture', function(Blueprint $table)
        {
            $table->integer('foodProduct_id')->unsigned()->index();
            $table->foreign('foodProduct_id')->references('id')->on('foodProducts')->onDelete('cascade');

            $table->integer('manufacture_id')->unsigned()->index();
            $table->foreign('manufacture_id')->references('id')->on('manufactures')->onDelete('cascade');

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
        Schema::drop('manufactures');
        Schema::drop('foodProduct_manufacture');
    }
}