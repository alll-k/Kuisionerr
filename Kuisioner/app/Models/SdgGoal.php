<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SdgGoal extends Model
{
    protected $fillable = ['number', 'title', 'description', 'color', 'icon'];

    /**
     * Get the questions for this SDG goal.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
