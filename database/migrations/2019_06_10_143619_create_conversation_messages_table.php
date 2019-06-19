<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('conversation_id')->index();

            $table->string('fingerprint')->index();

            $table->string('type')->nullable();

            $table->longText('content')->nullable();

            $table->timestamp('sent_at')->nullable();

            $table->timestamp('read_at')->nullable();

            $table->boolean('from_admin')->index()->default(false);

            $table->boolean('is_system_message')->index()->default(false);

            $table->string('idx')->index()->nullable();
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
        Schema::dropIfExists('conversation_messages');
    }
}
