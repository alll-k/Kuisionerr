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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained('questionnaires')->onDelete('cascade');
            $table->foreignId('sdg_goal_id')->constrained('sdg_goals')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['text', 'multiple_choice', 'scale', 'yes_no'])->default('multiple_choice');
            $table->json('options')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
