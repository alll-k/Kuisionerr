<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Questionnaire extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'sdg_goal_id',
        'target_role_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeForRole(Builder $query, int $roleId): Builder
    {
        return $query->where('target_role_id', $roleId);
    }

    public function scopeForRespondent(Builder $query, int $roleId): Builder
    {
        return $query->active()->forRole($roleId);
    }

    public function isAccessibleByRole(int $roleId): bool
    {
        return $this->status === 'active' && $this->target_role_id === $roleId;
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function targetRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'target_role_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }
}
