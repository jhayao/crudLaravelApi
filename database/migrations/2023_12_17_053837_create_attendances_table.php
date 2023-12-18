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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer("student_id");
            $table->integer("event_id");
            $table->string("attendance_status")->default("unregistered");
            // $table->string("attendance_remarks");
            $table->dateTime("attendance_date")->nullable();
            $table->unique(["student_id", "event_id"]);
            $table->foreign("student_id")->references("id")->on("students")->onDelete("cascade");
            $table->foreign("event_id")->references("id")->on("events")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
