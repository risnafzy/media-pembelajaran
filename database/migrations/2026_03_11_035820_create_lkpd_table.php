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
        if (!Schema::hasTable('lkpd')) {

        Schema::create('lkpd', function (Blueprint $table) {

            $table->id();

            $table->foreignId('course_id')->constrained()->cascadeOnDelete();

            $table->enum('tahapan_pbl',[
                'orientasi_masalah',
                'investigasi',
                'analisis',
                'refleksi'
            ]);

            $table->enum('indikator_ct',[
                'decomposition',
                'pattern_recognition',
                'abstraction',
                'algorithm'
            ]);

            $table->text('pertanyaan');

            $table->integer('urutan')->default(1);

            $table->timestamps();

        });
    }
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lkpd');
    }
};