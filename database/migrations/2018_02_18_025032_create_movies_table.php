<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('title')->default('');
            $table->bigInteger('budget')->default(0);
            $table->string('backdrop_path')->default('')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('original_language')->default('');
            $table->string('original_title')->default('');
            $table->text('overview')->nullable();
            $table->float('popularity', 10, 6)->default(0.0);
            $table->index('popularity');
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
            $table->index('release_date');
            $table->bigInteger('revenue')->default(0);
            $table->integer('runtime')->nullable();
            $table->string('status')->default('');
            $table->text('tagline')->nullable();
            $table->boolean('video')->default(false);
            $table->float('vote_average', 3, 1)->default(0.0);
            $table->integer('vote_count')->default(0);
            $table->index('vote_count');
            $table->float('imdb_rating', 3, 1)->nullable();  
            $table->index('imdb_rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
