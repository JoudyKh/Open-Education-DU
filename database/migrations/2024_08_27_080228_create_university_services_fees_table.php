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
        Schema::create('university_services_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')
            ->constrained('semesters')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('name');
            $table->double('fee');
            $table->double('discount_percentage');
            $table->foreignId('discount_type_id')
            ->constrained('discount_types')
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
        Schema::dropIfExists('university_services_fees');
    }
};
