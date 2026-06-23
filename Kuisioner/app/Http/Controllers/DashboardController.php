<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\UserAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show general dashboard based on user role.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('respondent.dashboard');
        }
    }

    /**
     * Show admin dashboard.
     */
    public function adminDashboard()
    {
        $totalQuestionnaires = Questionnaire::count();
        $activeQuestionnaires = Questionnaire::where('status', 'active')->count();
        $totalRespondents = User::whereHas('role', function($q) {
            $q->whereIn('name', ['dosen', 'mahasiswa']);
        })->count();
        $totalAnswers = UserAnswer::count();
        
        $recentQuestionnaires = Questionnaire::with(['targetRole', 'questions', 'answers'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalQuestionnaires',
            'activeQuestionnaires',
            'totalRespondents',
            'totalAnswers',
            'recentQuestionnaires'
        ));
    }

    /**
     * Show respondent dashboard.
     */
    public function respondentDashboard()
    {
        $user = Auth::user();
        
        $availableQuestionnaires = Questionnaire::where('target_role_id', $user->role_id)
            ->where('status', 'active')
            ->count();
        
        $completedQuestionnaires = UserAnswer::where('user_id', $user->id)
            ->distinct('questionnaire_id')
            ->count();
        
        $activeQuestionnaires = Questionnaire::where('target_role_id', $user->role_id)
            ->where('status', 'active')
            ->with(['questions', 'answers'])
            ->get();
        
        return view('respondent.dashboard', compact(
            'availableQuestionnaires',
            'completedQuestionnaires',
            'activeQuestionnaires'
        ));
    }

    /**
     * Show analytics dashboard.
     */
    public function adminAnalytics()
    {
        $totalAnswers = UserAnswer::count();
        $uniqueRespondents = UserAnswer::distinct('user_id')->count();
        $totalQuestionnaires = Questionnaire::count();
        
        $topQuestionnaires = Questionnaire::withCount('answers')
            ->orderBy('answers_count', 'desc')
            ->limit(5)
            ->get();
        
        $topRespondents = User::withCount('answers')
            ->where('role_id', '!=', 1) // Exclude admin
            ->orderBy('answers_count', 'desc')
            ->limit(5)
            ->with('role')
            ->get();
        
        return view('admin.analytics.index', compact(
            'totalAnswers',
            'uniqueRespondents',
            'totalQuestionnaires',
            'topQuestionnaires',
            'topRespondents'
        ));
    }

    /**
     * Export data.
     */
    public function export()
    {
        $answers = UserAnswer::with(['user', 'question', 'questionnaire'])
            ->get();
        
        $csv = "User,Email,Role,Kuesioner,Pertanyaan,Jawaban,Tanggal Menjawab\n";
        
        foreach ($answers as $answer) {
            $csv .= '"' . addslashes($answer->user->name) . '","' . 
                    $answer->user->email . '","' . 
                    $answer->user->role->name . '","' . 
                    addslashes($answer->questionnaire->title) . '","' . 
                    addslashes($answer->question->question_text) . '","' . 
                    addslashes($answer->answer_text) . '","' . 
                    $answer->answered_at . "\"\n";
        }
        
        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="export_kuesioner.csv"');
    }

    /**
     * Show profile.
     */
    public function showProfile()
    {
        return view('profile.show');
    }
}
