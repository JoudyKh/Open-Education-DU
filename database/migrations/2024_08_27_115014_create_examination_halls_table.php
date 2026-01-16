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
        Schema::create('examination_halls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')
            ->constrained('semesters')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('name');
            $table->string('place');
            $table->integer('default_capacity');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examination_halls');
    }
};
