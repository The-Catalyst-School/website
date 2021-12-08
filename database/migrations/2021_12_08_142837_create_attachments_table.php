<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug');
            $table->string('title')->nullable();
            $table->string('file')->nullable();
            $table->string('size')->nullable();
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
        Schema::dropIfExists('attachments');
    }
}
