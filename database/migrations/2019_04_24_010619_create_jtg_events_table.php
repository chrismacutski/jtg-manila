<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJtgEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jtg_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->index();

            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();

            $table->text('address')->nullable();

            // event id + event_banner = 1_event_banner.png
            $table->string('image_src')->index()->nullable();

            // event id + event_thumbnail = 1_event_thumbnail.png
            $table->string('image_thumbnail_src')->index()->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->dateTime('starting_at')->index()->nullable();
            $table->dateTime('ending_at')->index()->nullable();

            $table->dateTime('published_at')->index()->nullable();
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
        Schema::dropIfExists('jtg_events');
    }
}
