<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->text('description')->nullable();
            // series id + series_banner = 1_series_banner.png
            $table->string('image_src')->nullable();
            // series id + series_thumbnail = 1_series_thumbnail.png
            $table->string('image_thumbnail_src')->nullable();

            $table->timestamp('happened_at')->index()->nullable();

            $table->timestamp('published_at')->index()->nullable();

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
        Schema::dropIfExists('series');
    }
}
