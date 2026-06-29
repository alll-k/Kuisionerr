<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Questionnaire;
use App\Models\SdgGoal;
use App\Models\QuestionOption;

class Question extends Model
{
    protected $fillable = [
        'questionnaire_id',
        'sdg_goal_id',
        'question_text',
        'question_type',
        'order',
    ];

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function sdgGoal(): BelongsTo
    {
        return $this->belongsTo(SdgGoal::class, 'sdg_goal_id');
    }

    // Relasi ke pilihan jawaban
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }
}
