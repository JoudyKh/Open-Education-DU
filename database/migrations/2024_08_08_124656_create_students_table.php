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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name_ar');
            $table->string('first_name_en');
            $table->string('last_name_ar');
            $table->string('last_name_en');
            $table->string('father_name_ar');
            $table->string('father_name_en');
            $table->string('mother_name_ar');
            $table->string('mother_name_en');
            $table->string('national_id')->unique()->nullable();
            $table->string('birth_place_ar')->nullable();
            $table->string('birth_place_en')->nullable();
            $table->date('birth_date')->nullable();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('set null');
            $table->string('id_number')->nullable()->unique();
            $table->enum('gender', [Constants::MALE_GENDER, Constants::FEMALE_GENDER]);
            $table->string('place_of_registration')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('passport_number')->unique()->nullable();
            $table->string('recruitment_division')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('set null');
            $table->string('university_id', 6)->unique(); 
            $table->string('personal_picture')->nullable();
            $table->string('id_front_side_image')->nullable();
            $table->string('id_back_side_image')->nullable();
            $table->boolean('is_active')->default(0);
            $table->string('password');
            $table->boolean('is_default')->default(1);
            $table->boolean('is_checked')->default(0);
            $table->enum('student_type', Constants::STUDENTS_TYPES);
            $table->timestamps();
            $table->softDeletes();
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
