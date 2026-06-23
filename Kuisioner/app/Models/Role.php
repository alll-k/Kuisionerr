<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * Get the users for this role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the questionnaires for this role.
     */
    public function questionnaires(): HasMany
    {
        return $this->hasMany(Questionnaire::class, 'target_role_id');
    }
}
