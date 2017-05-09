<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthAndSafetyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_and_safety', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('category');
            $table->string('content', 10000);
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
        Schema::drop('health_and_safety');
    }
}
