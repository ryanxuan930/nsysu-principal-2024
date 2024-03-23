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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('student_id')->unique();
            $table->string('phone')->unique();
            $table->ipAddress('ip')->default('0.0.0.0');
            $table->datetime('check_in')->nullable();
            $table->datetime('check_out')->nullable();
            $table->char('area', 1)->default('0');
            $table->integer('row')->default(0);
            $table->integer('no')->defualt(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
