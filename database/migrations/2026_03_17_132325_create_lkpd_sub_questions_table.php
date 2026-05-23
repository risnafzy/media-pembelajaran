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
       Schema::create('lkpd_sub_questions', function (Blueprint $table) {
            $table->id();
            // Jika question dihapus, sub-soal otomatis terhapus
            $table->foreignId('question_id')->constrained('lkpd_questions')->cascadeOnDelete();
            $table->string('label');
            $table->text('pertanyaan');
            $table->string('tipe_jawaban')->default('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lkpd_sub_questions');
    }
};
