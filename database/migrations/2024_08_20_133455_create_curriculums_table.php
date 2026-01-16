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
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_en');
            $table->string('name_ar');
            $table->double('min_pass_mark');
            $table->double('theoretical_mark');
            $table->double('practical_mark');
            $table->double('assistances_marks');
            $table->enum('type', ['traditional', 'automated']);
            $table->boolean('is_optional');
            $table->string('description_file')->nullable();
            $table->boolean('in_program')->default(0);
            $table->integer('year');
            $table->foreignId('semester_id')
            ->constrained('semesters')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculums');
    }
};
