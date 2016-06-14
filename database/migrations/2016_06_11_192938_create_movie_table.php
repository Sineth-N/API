<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title');
            $table->string('title_long');
            $table->integer('year');
            $table->float('rating');
            $table->integer('runtime');
            $table->string('genre');
            $table->string('synopsis',2048);
            $table->string('yt_trailer_code');
            $table->string('small_cover_image');
            $table->string('large_cover_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('movie');
    }
}
