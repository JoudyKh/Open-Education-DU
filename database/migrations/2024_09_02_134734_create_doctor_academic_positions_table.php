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
        Schema::create('doctor_academic_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_year');
            $table->date('end_year');
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
        Schema::dropIfExists('doctor_academic_positions');
    }
};
