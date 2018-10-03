<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreTvshowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_tvshow', function (Blueprint $table) {
            $table->integer('genre_id')->unsigned()->index();
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->integer('tvshow_id')->unsigned()->index();
            $table->foreign('tvshow_id')->references('id')->on('tvshows')->onDelete('cascade');
            $table->primary(['genre_id', 'tvshow_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genre_tvshow');
    }
}
