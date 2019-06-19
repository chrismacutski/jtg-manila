<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('phone_number')->index()->nullable();
            $table->string('email_address')->index()->nullable();
            $table->integer('adult_count')->default(0);
            $table->integer('children_count')->default(0);
            $table->timestamp('visiting_at')->index();
            $table->timestamp('notified_at')->index()->nullable();
            $table->timestamp('followed_up_at')->index()->nullable();
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
        Schema::dropIfExists('visitors');
    }
}
