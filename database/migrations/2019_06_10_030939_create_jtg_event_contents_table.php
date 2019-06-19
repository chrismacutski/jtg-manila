<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJtgEventContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jtg_event_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('event_id')->index();
            $table->string('type')->index();
            $table->string('header_text')->index()->nullable();
            $table->longText('text_content')->nullable();
            $table->string('video_url')->index()->nullable();
            $table->longText('slider_images')->nullable();
            $table->integer('sorter')->index()->nullable();
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
        Schema::dropIfExists('jtg_event_contents');
    }
}
