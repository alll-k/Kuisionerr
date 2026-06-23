<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    // Tambahkan 'status' agar bisa disimpan
    protected $fillable = ['title', 'description', 'status', 'sdg_goal_id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}