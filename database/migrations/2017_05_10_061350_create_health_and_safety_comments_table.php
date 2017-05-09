<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthAndSafetyCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_and_safety_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comment', 2000);
            $table->integer('health_and_safety_id')->unsigned();
            $table->foreign('health_and_safety_id')->references('id')->on('health_and_safety');
            $table->string('username');
            $table->foreign('username')->references('username')->on('accounts');
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
        Schema::drop('health_and_safety_comments');
    }
}
