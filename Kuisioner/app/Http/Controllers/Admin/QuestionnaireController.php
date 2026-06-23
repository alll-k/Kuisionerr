<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\Role;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of questionnaires.
     */
    public function index()
    {
        $questionnaires = Questionnaire::with('targetRole')->paginate(15);
        return view('admin.questionnaires.index', compact('questionnaires'));
    }

    /**
     * Show the form for creating a new questionnaire.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.questionnaires.create', compact('roles'));
    }

    /**
     * Store a newly created questionnaire in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_role_id' => 'required|exists:roles,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        Questionnaire::create($validated);

        return redirect()->route('admin.questionnaires.index')->with('success', 'Kuesioner berhasil dibuat.');
    }

    /**
     * Display the specified questionnaire.
     */
    public function show(Questionnaire $questionnaire)
    {
        $questionnaire->load('questions.sdgGoal');
        return view('admin.questionnaires.show', compact('questionnaire'));
    }

    /**
     * Show the form for editing the specified questionnaire.
     */
    public function edit(Questionnaire $questionnaire)
    {
        $roles = Role::all();
        return view('admin.questionnaires.edit', compact('questionnaire', 'roles'));
    }

    /**
     * Update the specified questionnaire in database.
     */
    public function update(Request $request, Questionnaire $questionnaire)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_role_id' => 'required|exists:roles,id',
            'status' => 'required|in:draft,active,closed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $questionnaire->update($validated);

        return redirect()->route('admin.questionnaires.index')->with('success', 'Kuesioner berhasil diperbarui.');
    }

    /**
     * Remove the specified questionnaire from database.
     */
    public function destroy(Questionnaire $questionnaire)
    {
        $questionnaire->delete();
        return redirect()->route('admin.questionnaires.index')->with('success', 'Kuesioner berhasil dihapus.');
    }

    /**
     * Show questions for a questionnaire.
     */
    public function showQuestions(Questionnaire $questionnaire)
    {
        $questionnaire->load('questions.sdgGoal');
        return view('admin.questionnaires.questions', compact('questionnaire'));
    }
}
