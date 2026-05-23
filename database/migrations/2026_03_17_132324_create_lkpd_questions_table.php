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
        Schema::create('lkpd_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('lkpd_cases')->cascadeOnDelete();
            $table->integer('no_soal'); // 1,2,3
            $table->text('deskripsi')->nullable(); // sebelum a,b,c
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lkpd_questions');
    }
};
