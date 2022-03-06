<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeoDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('seo_description')->nullable();
        });
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('seo_description')->nullable();
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->string('seo_description')->nullable();
        });
        Schema::table('workshops', function (Blueprint $table) {
            $table->string('seo_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['seo_description']);
        });
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['seo_description']);
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['seo_description']);
        });
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn(['seo_description']);
        });
    }
}
