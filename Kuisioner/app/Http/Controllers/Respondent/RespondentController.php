<?php

namespace App\Http\Controllers\Respondent;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class RespondentController extends Controller
{
    /**
     * Display list of questionnaires for the respondent.
     */
    public function index()
    {
        $user = auth()->user();

        // Hanya tampilkan kuesioner aktif untuk role pengguna saat ini
        $questionnaires = Questionnaire::forRespondent($user->role_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('respondent.index', compact('questionnaires'));
    }

    /**
     * Display a specific questionnaire for filling.
     */
    public function show(Questionnaire $questionnaire)
    {
        $user = auth()->user();

        if (! $questionnaire->isAccessibleByRole($user->role_id)) {
            abort(403, 'Unauthorized');
        }

        $questions = $questionnaire->questions()->with(['sdgGoal', 'options'])->orderBy('order')->get();
        $questionnaire->setRelation('questions', $questions);

        return view('respondent.show', compact('questionnaire'));
    }

    /**
     * Submit questionnaire answers.
     */
    public function submit(Request $request, Questionnaire $questionnaire)
    {
        // Check if user's role matches the questionnaire's target role and if it is active
        if (! $questionnaire->isAccessibleByRole(auth()->user()->role_id)) {
            abort(403, 'Unauthorized');
        }

        // Validate that all questions are answered
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required',
        ], [
            'answers.required' => 'Harap jawab semua pertanyaan',
            'answers.*.required' => 'Semua pertanyaan harus dijawab',
        ]);

        try {
            // Delete old answers if any
            UserAnswer::where('user_id', auth()->id())
                ->where('questionnaire_id', $questionnaire->id)
                ->delete();

            // Save all answers
            foreach ($validated['answers'] as $questionId => $answerText) {
                UserAnswer::create([
                    'user_id' => auth()->id(),
                    'questionnaire_id' => $questionnaire->id,
                    'question_id' => $questionId,
                    'answer_text' => $answerText,
                    'answered_at' => now(),
                ]);
            }

            return redirect()->route('respondent.questionnaires')
                ->with('success', 'Jawaban Anda berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.');
        }
    }
}
