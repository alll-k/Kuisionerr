<?php

namespace App\Policies;

use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionnairePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Questionnaire $questionnaire): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Questionnaire $questionnaire): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Questionnaire $questionnaire): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Questionnaire $questionnaire): bool
    {
        return false;
    }

    /**
     * Determine whether the user can respond to the questionnaire.
     */
    public function respond(User $user, Questionnaire $questionnaire): bool
    {
        return $user->role_id === $questionnaire->target_role_id;
    }
