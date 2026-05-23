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
        Schema::create('lkpd_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->nullable()->constrained('lkpd_questions')->cascadeOnDelete();
$table->foreignId('sub_question_id')->nullable()->constrained('lkpd_sub_questions')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->text('jawaban')->nullable();
                        $table->integer('score')->nullable(); // nilai per jawaban

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lkpd_answers');
    }
};
