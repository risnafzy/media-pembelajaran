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
    Schema::create('jawaban_pertanyaan_orientasis', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pertanyaan_orientasi_id')
              ->constrained('pertanyaan_orientasis')
              ->onDelete('cascade');

        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        $table->text('jawaban');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_pertanyaan_orientasis');
    }
};