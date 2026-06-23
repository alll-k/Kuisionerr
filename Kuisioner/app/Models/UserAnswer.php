<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    protected $fillable = ['user_id', 'questionnaire_id', 'question_id', 'answer_text', 'answer_value', 'answered_at'];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    /**
     * Get the user for this answer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the questionnaire for this answer.
     */
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * Get the question for this answer.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
