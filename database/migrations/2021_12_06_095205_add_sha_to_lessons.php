<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShaToLessons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('sha');
            $table->string('github_path');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->string('sha');
            $table->string('github_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['sha', 'github_path']);
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['sha', 'github_path']);
        });
    }
}
