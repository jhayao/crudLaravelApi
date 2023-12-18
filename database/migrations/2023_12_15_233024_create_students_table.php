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
            $table->integer("id")->autoIncrement();
            $table->string('student_name', 100);
            $table->string('student_email', 100);
            $table->string('student_phone', 100)->nullable();
            $table->string('student_address', 100)->nullable();
            $table->foreign('student_email')->references('email')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->string('student_image', 100);
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
