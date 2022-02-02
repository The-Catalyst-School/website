<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsToWorkshops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->string('teacher')->nullable();
            $table->string('estimated_time')->nullable();
            $table->string('difficulty')->nullable();
            $table->string('intro')->nullable();
            $table->string('featured')->nullable();
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
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn([
              'teacher', 'estimated_time', 'difficulty',
              'intro', 'featured', 'sha', 'github_path'
            ]);
        });
    }
}
