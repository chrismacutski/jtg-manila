<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEventAttendeesTableToAddTheMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jtg_event_attendees', function (Blueprint $table) {
            $table->longText('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jtg_event_attendees', function (Blueprint $table) {
            $table->dropColumn('message');
        });
    }
}
