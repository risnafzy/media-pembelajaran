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
        Schema::create('lkpd_presentations', function (Blueprint $table) {


            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('lkpd_case_id')
                ->constrained('lkpd_cases')
                ->cascadeOnDelete();

            $table->text('argumen_solusi')->nullable();

            $table->text('temuan_pola')->nullable();

            $table->timestamps();


        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lkpd_presentations');
    }
};