<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->integer('tvshow_id')->unsigned()->index();
            $table->foreign('tvshow_id')->references('id')->on('tvshows');
            $table->integer('season_id')->unsigned()->index();
            $table->integer('episode_id')->unsigned()->index();
            $table->primary(['tvshow_id', 'season_id', 'episode_id']);
            $table->date('air_date')->nullable();
            $table->text('name')->nullable();
            $table->text('overview')->nullable();
            $table->string('still_path')->nullable();
            $table->integer('episode_number')->nullable();
            $table->integer('season_number')->nullable();
            $table->float('vote_average', 3, 1)->default(0.0);
            $table->integer('vote_count')->default(0);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
}
