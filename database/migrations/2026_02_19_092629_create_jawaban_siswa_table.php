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
       Schema::create('jawaban_siswa', function (Blueprint $table) {

    $table->id();

    $table->foreignId('siswa_id')
        ->constrained('users')
        ->cascadeOnDelete();

    $table->foreignId('bank_soal_id')
        ->constrained('bank_soal')
        ->cascadeOnDelete();

    $table->string('jenis'); // pretest / posttest

    $table->string('jawaban');

    $table->boolean('benar');

    $table->timestamps();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswa');
    }
};
