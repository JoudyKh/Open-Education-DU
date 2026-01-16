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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('national_id')->unique();
            $table->string('place_of_registration');
            $table->string('id_front_side_image');
            $table->string('id_back_side_image');
            $table->date('admin_decision_date')->nullable();
            $table->string('admin_decision_number')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
