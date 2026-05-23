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
        Schema::create('course_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();

            $table->boolean('orientasi')->default(false);
            $table->boolean('lkpd1')->default(false);
            $table->boolean('materi')->default(false);
            $table->boolean('lkpd2')->default(false);
            $table->boolean('code')->default(false);
            $table->boolean('lkpd3')->default(false);
            $table->boolean('refleksi')->default(false);
                        $table->boolean('presentasi_done')->default(false);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_progress');
    }
};