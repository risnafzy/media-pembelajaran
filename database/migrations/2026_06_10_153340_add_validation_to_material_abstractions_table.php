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
        Schema::table('material_abstractions', function (Blueprint $table) {

    $table->enum('status_validasi', [
        'tepat',
        'sebagian_tepat',
        'kurang_tepat'
    ])->nullable();

    $table->text('feedback_guru')->nullable();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_abstractions', function (Blueprint $table) {
            //
        });
    }
};