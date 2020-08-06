<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('participant_id')->unsigned()->nullable();
            $table->bigInteger('quiz_id')->unsigned()->nullable();
            $table->bigInteger('correct_answers')->unsigned()->nullable()->default(0);
            $table->bigInteger('questions_count')->unsigned()->nullable();
            $table->timestamps();

            $table->index('participant_id');
            $table->index('quiz_id');
            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
