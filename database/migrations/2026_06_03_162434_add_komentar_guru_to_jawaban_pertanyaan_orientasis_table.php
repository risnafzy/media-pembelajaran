<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jawaban_pertanyaan_orientasis', function (Blueprint $table) {
            $table->text('komentar_guru')->nullable()->after('jawaban');
        });
    }

    public function down(): void
    {
        Schema::table('jawaban_pertanyaan_orientasis', function (Blueprint $table) {
            $table->dropColumn('komentar_guru');
        });
    }
};
