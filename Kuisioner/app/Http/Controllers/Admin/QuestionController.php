<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, Questionnaire $questionnaire)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:text,radio,checkbox',
            'options' => 'nullable|array', // Validasi array pilihan jawaban
            'options.*' => 'required|string'
        ]);

        // Simpan pertanyaan
        $question = $questionnaire->questions()->create([
            'question_text' => $request->question_text,
            'type' => $request->type,
        ]);

        // Jika tipe pertanyaan butuh pilihan (Radio/Checkbox), simpan opsinya
        if (in_array($request->type, ['radio', 'checkbox']) && $request->has('options')) {
            foreach ($request->options as $optionText) {
                $question->options()->create([
                    'option_text' => $optionText
                ]);
            }
        }

        return back()->with('success', 'Pertanyaan dan pilihan berhasil ditambahkan!');
    }
}