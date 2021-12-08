<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmbedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('embeds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')
              ->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->foreign('lesson_id')
              ->references('id')->on('lessons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('embeds');
    }
}
