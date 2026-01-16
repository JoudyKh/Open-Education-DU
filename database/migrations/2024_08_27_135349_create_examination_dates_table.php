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
        Schema::create('examination_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')
            ->constrained('semesters')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('curriculum_id')
            ->constrained('curriculums')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examination_dates');
    }
};
