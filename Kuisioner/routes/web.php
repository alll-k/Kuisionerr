<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Respondent\RespondentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Route
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard')->middleware('role:admin');
    Route::get('/analytics', [DashboardController::class, 'adminAnalytics'])->name('analytics')->middleware('role:admin');
    Route::get('/export', [DashboardController::class, 'export'])->name('export')->middleware('role:admin');
    
    // Questionnaire Management
    Route::resource('questionnaires', QuestionnaireController::class)->middleware('role:admin');
    
    // Question Management
    Route::resource('questions', QuestionController::class)->middleware('role:admin');
    Route::post('questionnaires/{questionnaire}/questions', [QuestionController::class, 'store'])->name('questions.store')->middleware('role:admin');
});

// Respondent Routes
Route::middleware('auth')->prefix('respondent')->name('respondent.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'respondentDashboard'])->name('dashboard');
    Route::get('/questionnaires', [RespondentController::class, 'index'])->name('questionnaires');
    Route::get('/questionnaires/{questionnaire}', [RespondentController::class, 'show'])->name('show');
    Route::post('/questionnaires/{questionnaire}/submit', [RespondentController::class, 'submit'])->name('submit');
});

