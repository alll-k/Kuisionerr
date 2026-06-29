@extends('layouts.app')

@section('title', 'Dashboard - UNIMUS EduConnect')

@section('content')
<h2 class="mb-4"><i class="fas fa-chart-line"></i> Kuesioner Saya</h2>

@if ($questionnaires->count() > 0)
    <div class="row">
        @foreach ($questionnaires as $questionnaire)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title">{{ $questionnaire->title }}</h5>
                            @if ($completedQuestionnaires->contains($questionnaire->id))
                                <span class="badge bg-success"><i class="fas fa-check"></i> Selesai</span>
                            @else
                                <span class="badge bg-warning"><i class="fas fa-clock"></i> Belum</span>
                            @endif
                        </div>
                        <p class="card-text text-muted">{{ $questionnaire->description }}</p>
                        <p class="card-text small">
                            <strong>Target SDGs:</strong> {{ $questionnaire->targetRole->name }}<br>
                            <strong>Jumlah Pertanyaan:</strong> {{ $questionnaire->questions->count() }}
                        </p>
                        @if ($questionnaire->status === 'active')
                            <a href="{{ route('respondent.show', $questionnaire) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-alt"></i> {{ $completedQuestionnaires->contains($questionnaire->id) ? 'Lihat Kembali' : 'Mulai Menjawab' }}
                            </a>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>Kuesioner Ditutup</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> Belum ada kuesioner aktif untuk Anda. Silakan tunggu admin membuat kuesioner baru.
    </div>
@endif
@endsection
