<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmbedsToWorkshops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('embeds', function (Blueprint $table) {
            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->foreign('workshop_id')
              ->references('id')->on('workshops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('embeds', function (Blueprint $table) {
          $table->dropForeign(['workshop_id']);
          $table->dropColumn(['workshop_id']);
        });
    }
}
