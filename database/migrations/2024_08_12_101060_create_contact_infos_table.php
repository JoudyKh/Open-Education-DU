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
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
            ->constrained('students')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('phone_number')->nullable();
            $table->string('landline_number')->nullable();
            $table->unsignedBigInteger('city_of_residence_id')->nullable();
            $table->foreign('city_of_residence_id')->references('id')->on('cities')->onDelete('set null');
            $table->string('email')->unique()->nullable();
            $table->longText('permanent_address')->nullable();
            $table->longText('current_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};
