<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSermonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sermons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('series_id')->index()->nullable();
            $table->unsignedInteger('sermon_speaker_id')->index();
            $table->string('type')->index();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            // sermon id + sermon_banner = 1_sermon_banner.png
            $table->string('image_src')->nullable();
            // sermon id + sermon_banner = 1_sermon_banner.png
            $table->string('image_thumbnail_src')->nullable();

            // link from youtube
            $table->string('video_src')->index()->nullable();

            $table->timestamp('published_at')->index()->nullable();
            $table->timestamp('happened_at')->index()->nullable();

            $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sermons');
    }
}
