<?php

use App\Constants\Constants;
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
        Schema::create('academic_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
            ->constrained('students')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->enum('type', Constants::ACADEMIC_TYPES)->nullable();
            $table->enum('high_school_type', Constants::HIGH_SCHOOL_TYPES)->nullable();
            $table->string('high_school_certificate_source')->nullable();
            $table->double('total_student_score')->nullable();
            $table->double('total_certificate_score')->nullable();
            $table->date('high_school_year')->nullable();
            $table->string('differential_rate')->nullable();
            $table->string('english_language_degree')->nullable();
            $table->string('french_language_degree')->nullable();
            $table->string('religious_education_degree')->nullable();
            $table->enum('high_school_certificate_language', ['english', 'french'])->nullable();
            $table->string('high_school_certificate_photo')->nullable();
            $table->string('institute_name')->nullable();
            $table->string('institute_specialization')->nullable();
            $table->double('graduation_rate')->nullable();
            $table->date('graduation_year')->nullable();
            $table->string('institute_certificate_image')->nullable();
            $table->string('institute_transcript_file')->nullable();
            $table->string('document_decisive')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_infos');
    }
};
