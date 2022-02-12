<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeScheduledAtFormat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at']);
        });
        Schema::table('events', function (Blueprint $table) {
            $table->datetime('scheduled_at')->nullable();
            $table->string('short_title')->nullable();
            $table->boolean('special')->nullable();
        });
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at']);
        });
        Schema::table('workshops', function (Blueprint $table) {
            $table->datetime('scheduled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at', 'short_title', 'special']);
        });
        Schema::table('events', function (Blueprint $table) {
            $table->date('scheduled_at')->nullable();
        });
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at']);
        });
        Schema::table('workshops', function (Blueprint $table) {
            $table->date('scheduled_at')->nullable();
        });
    }
}
