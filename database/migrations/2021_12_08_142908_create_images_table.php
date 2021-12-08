<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('url')->nullable();
            $table->string('large')->nullable();
            $table->string('portrait_medium')->nullable();
            $table->string('landscape_medium')->nullable();
            $table->string('list_medium')->nullable();
            $table->string('list_small')->nullable();
            $table->text('caption')->nullable();
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
        Schema::dropIfExists('images');
    }
}
