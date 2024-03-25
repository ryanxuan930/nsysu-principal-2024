<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->bigInteger('student_id')->unsigned();
            $table->string('identity');
            $table->string('college');
            $table->string('grade');
            $table->integer('q1_score');
            $table->text('q1_comment');
            $table->integer('q2_score');
            $table->text('q2_comment');
            $table->text('q3_comment');
            $table->integer('q4_score');
            $table->text('q4_comment');
            $table->text('q5_comment');
            $table->text('q6_comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
