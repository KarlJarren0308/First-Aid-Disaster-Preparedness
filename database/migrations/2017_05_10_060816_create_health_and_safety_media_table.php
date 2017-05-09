<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthAndSafetyMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_and_safety_media', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('health_and_safety_id')->unsigned();
            $table->foreign('health_and_safety_id')->references('id')->on('health_and_safety');
            $table->string('filename', 255);
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
        Schema::drop('health_and_safety_media');
    }
}
