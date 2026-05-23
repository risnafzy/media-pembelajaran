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
    Schema::create('pertanyaan_orientasis', function (Blueprint $table) {
        $table->id();

        $table->foreignId('orientasi_id')
              ->constrained('orientasis')
              ->onDelete('cascade');

        $table->text('pertanyaan');
        $table->string('tipe')->nullable(); // analisis, prediksi, debugging, refleksi
        $table->string('level_kognitif')->nullable(); // C3, C4, C5
        $table->integer('urutan')->default(1);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('pertanyaan_orientasis');
}
};
