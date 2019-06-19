<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('link')->index()->nullable();

            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('chatter_id')->index()->nullable();

            $table->string('session_id')->index();

            $table->string('status')->index();

            $table->timestamp('received_at')->index()->nullable();
            $table->timestamp('closed_at')->index()->nullable();

            $table->timestamp('assigned_at')->index()->nullable();
            $table->integer('assignment_time')->nullable();

            $table->boolean('was_queued')->index()->default(false);
            $table->boolean('was_sent_queueing_message')->index()->default(false);

            $table->timestamp('queued_at')->index()->nullable();
            $table->integer('queued_time')->nullable();
            $table->integer('queue_position')->default(0);

            $table->boolean('was_sent_auto_reply')->index()->default(false);

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
        Schema::dropIfExists('conversations');
    }
}
