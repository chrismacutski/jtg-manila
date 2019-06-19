<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJtgEventAttendees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jtg_event_attendees', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('event_id')->index();

            $table->unsignedInteger('member_id')->index()->nullable();

            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('phone_number')->index()->nullable();
            $table->string('email_address')->index()->nullable();

            $table->decimal('amount_paid', 8, 2)->default('0.00');
            $table->timestamp('paid_at')->index()->nullable();
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
        Schema::dropIfExists('jtg_event_attendees');
    }
}
