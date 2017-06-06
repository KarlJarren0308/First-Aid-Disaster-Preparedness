<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelfTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_test', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('for');
            $table->string('questions', 10000);
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
        Schema::drop('self_test');
    }
}
