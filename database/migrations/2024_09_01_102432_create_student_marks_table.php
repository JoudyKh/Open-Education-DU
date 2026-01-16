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
        Schema::create('student_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
            ->constrained('students')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('semester_id')
            ->constrained('semesters')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('curriculum_id')
            ->constrained('curriculums')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->double('mark');
            $table->string('written_mark');
            $table->boolean('is_successful');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_marks');
    }
};
