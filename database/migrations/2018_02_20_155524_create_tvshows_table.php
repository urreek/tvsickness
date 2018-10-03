<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvshowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvshows', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('backdrop_path')->default('')->nullable();
            $table->date('first_air_date')->nullable();
            $table->text('homepage')->nullable();
            $table->boolean('in_production')->default(false);
            $table->date('last_air_date')->nullable();
            $table->string('name')->default('')->nullable();
            $table->integer('number_of_episodes')->unsigned()->nullable();
            $table->integer('number_of_seasons')->unsigned()->nullable();
            $table->string('original_language')->default('')->nullable();
            $table->string('original_name')->default('')->nullable();
            $table->text('overview')->nullable();
            $table->float('popularity', 10, 6)->default(0.0);
            $table->string('poster_path')->nullable();
            $table->string('status')->default('');
            $table->string('type')->default('');
            $table->float('vote_average', 3, 1)->default(0.0);
            $table->integer('vote_count')->default(0);  
            $table->float('imdb_rating', 3, 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvshows');
    }
}
