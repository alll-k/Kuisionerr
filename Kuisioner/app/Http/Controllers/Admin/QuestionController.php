<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\SdgGoal;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Questionnaire $questionnaire)
    {
        $sdgGoals = SdgGoal::all();
        return view('admin.questions.create', compact('questionnaire', 'sdgGoals'));
    }

    public function edit(Question $question)
    {
        $sdgGoals = SdgGoal::all();
        return view('admin.questions.edit', compact('question', 'sdgGoals'));
    }

    public function update(Request $request, Question $question)
    {
        $rules = [
            'question_text' => 'required|string',
            'sdg_goal_id' => 'required|exists:sdg_goals,id',
            'type' => 'required|in:text,multiple_choice,scale,yes_no',
            'options' => 'nullable|array',
            'options.*' => 'required|string',
        ];

        if ($request->input('type') === 'multiple_choice') {
            $rules['options'] = 'required|array|min:1';
        }

        $validated = $request->validate($rules, [
            'options.required' => 'Pilihan jawaban diperlukan untuk pertanyaan pilihan ganda.',
            'options.min' => 'Tambahkan setidaknya satu pilihan jawaban.',
        ]);

        $question->update([
            'question_text' => $validated['question_text'],
            'sdg_goal_id' => $validated['sdg_goal_id'],
            'question_type' => $validated['type'],
        ]);

        if ($validated['type'] === 'multiple_choice') {
            $question->questionOptions()->delete();
            foreach ($validated['options'] as $optionText) {
                $question->questionOptions()->create([
                    'option_text' => $optionText,
                ]);
            }
        } else {
            $question->questionOptions()->delete();
        }

        return redirect()->route('admin.questionnaires.show', $question->questionnaire)
            ->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy(Question $question)
    {
        $questionnaire = $question->questionnaire;
        $question->delete();

        return redirect()->route('admin.questionnaires.show', $questionnaire)
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }

    public function store(Request $request, Questionnaire $questionnaire)
    {
        $rules = [
            'question_text' => 'required|string',
            'sdg_goal_id' => 'required|exists:sdg_goals,id',
            'type' => 'required|in:text,multiple_choice,scale,yes_no',
            'options' => 'nullable|array',
            'options.*' => 'required|string',
        ];

        if ($request->input('type') === 'multiple_choice') {
            $rules['options'] = 'required|array|min:1';
        }

        $validated = $request->validate($rules, [
            'options.required' => 'Pilihan jawaban diperlukan untuk pertanyaan pilihan ganda.',
            'options.min' => 'Tambahkan setidaknya satu pilihan jawaban.',
        ]);

        // Simpan pertanyaan
        $question = $questionnaire->questions()->create([
            'question_text' => $validated['question_text'],
            'sdg_goal_id' => $validated['sdg_goal_id'],
            'question_type' => $validated['type'],
        ]);

        // Jika tipe pertanyaan membutuhkan pilihan jawaban, simpan opsinya
        if ($validated['type'] === 'multiple_choice' && $request->has('options')) {
            foreach ($request->options as $optionText) {
                $question->questionOptions()->create([
                    'option_text' => $optionText
                ]);
            }
        }

        return back()->with('success', 'Pertanyaan dan pilihan berhasil ditambahkan!');
    }
}
