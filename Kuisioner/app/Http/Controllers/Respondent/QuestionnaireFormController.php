<?php

namespace App\Http\Controllers\Respondent;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireFormController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $questionnaires = Questionnaire::where('target_role_id', $user->role_id)
            ->where('status', 'active')
            ->get();

        $completedQuestionnaires = UserAnswer::where('user_id', $user->id)
            ->distinct('questionnaire_id')
            ->pluck('questionnaire_id');

        return view('questionnaires.index', compact('questionnaires', 'completedQuestionnaires'));
    }

    public function show(Questionnaire $questionnaire)
    {
        $this->authorize('respond', $questionnaire);
        
        $questions = $questionnaire->questions()->orderBy('order')->get();
        $userAnswers = UserAnswer::where('user_id', Auth::id())
            ->where('questionnaire_id', $questionnaire->id)
            ->pluck('answer_text', 'question_id');

        return view('questionnaires.show', compact('questionnaire', 'questions', 'userAnswers'));
    }

    public function getQuestion(Questionnaire $questionnaire, Question $question)
    {
        $this->authorize('respond', $questionnaire);

        $userAnswer = UserAnswer::where('user_id', Auth::id())
            ->where('question_id', $question->id)
            ->first();

        return response()->json([
            'question' => $question,
            'userAnswer' => $userAnswer?->answer_text,
        ]);
    }

    public function saveAnswer(Request $request, Questionnaire $questionnaire, Question $question)
    {
        $this->authorize('respond', $questionnaire);

        $validated = $request->validate([
            'answer' => 'required',
        ]);

        UserAnswer::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'question_id' => $question->id,
                'questionnaire_id' => $questionnaire->id,
            ],
            [
                'answer_text' => $validated['answer'],
                'answered_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }

    public function submit(Questionnaire $questionnaire)
    {
        $this->authorize('respond', $questionnaire);

        // Mark questionnaire as completed
        UserAnswer::where('user_id', Auth::id())
            ->where('questionnaire_id', $questionnaire->id)
            ->update(['answered_at' => now()]);

        return redirect()->route('questionnaires.index')
            ->with('success', 'Kuesioner berhasil diserahkan.');
    }
}
}
