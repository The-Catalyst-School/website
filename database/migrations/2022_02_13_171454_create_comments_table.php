<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
              ->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')
              ->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->foreign('lesson_id')
              ->references('id')->on('lessons')->onDelete('cascade');
            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->foreign('workshop_id')
              ->references('id')->on('workshops')->onDelete('cascade');
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
        Schema::dropIfExists('comments');
    }
}
