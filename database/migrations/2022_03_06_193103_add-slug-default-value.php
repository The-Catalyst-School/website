<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn(['slug', 'sha', 'github_path']);
        });
        Schema::table('workshops', function (Blueprint $table) {
            $table->string('slug')->nullable();
            $table->string('sha')->nullable();
            $table->string('github_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn(['slug', 'sha', 'github_path']);
        });
        Schema::table('workshops', function (Blueprint $table) {
            $table->string('slug');
            $table->string('sha');
            $table->string('github_path');
        });
    }
}
