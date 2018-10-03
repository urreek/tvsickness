<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->integer('tvshow_id')->unsigned()->index();
            $table->foreign('tvshow_id')->references('id')->on('tvshows');
            $table->integer('season_id')->unsigned()->index();
            $table->primary(['tvshow_id', 'season_id']);
            $table->date('air_date')->nullable();
            $table->string('name')->default('')->nullable();
            $table->text('overview')->nullable();
            $table->string('poster_path')->nullable();
            $table->integer('season_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seasons');
    }
}
