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
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->date('year');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('registration_start_date');
            $table->date('registration_end_date');
            $table->boolean('has_exception');
            $table->integer('max_fail_regular');
            $table->integer('max_fail_dropout');
            $table->integer('count_curriculums_optional');
            $table->integer('count_curriculums_mandatory');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
