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
        Schema::create('doctor_academic_infos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('thesis_title');
            $table->string('university_name');
            $table->string('collage_name');
            $table->string('specialization');
            $table->date('graduation_year');
            $table->double('rate');
            $table->string('degree');
            $table->foreignId('doctor_id')
            ->constrained('doctors')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_academic_infos');
    }
};
