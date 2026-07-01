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
    public function questionOptions(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function options(): HasMany
    {
        return $this->questionOptions();
    }

    public function getOptionsAttribute($value)
    {
        if ($this->relationLoaded('questionOptions')) {
            return $this->getRelation('questionOptions');
        }

        if (!is_null($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return collect($decoded)->map(function ($option) {
                    return (object) ['option_text' => $option];
                });
            }
        }

        return $this->questionOptions;
    }
}
