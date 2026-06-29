<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
                $question->options()->create([
                    'option_text' => $optionText
                ]);
            }
        }

        return back()->with('success', 'Pertanyaan dan pilihan berhasil ditambahkan!');
    }
}
