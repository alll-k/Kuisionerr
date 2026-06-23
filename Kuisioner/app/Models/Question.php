<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['questionnaire_id', 'question_text', 'type'];

    // Relasi ke pilihan jawaban
    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}