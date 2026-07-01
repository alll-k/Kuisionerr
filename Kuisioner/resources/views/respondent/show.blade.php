@extends('layouts.app')

@section('title', $questionnaire->title)

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('respondent.questionnaires') }}" class="btn btn-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{ $questionnaire->title }}</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">{{ $questionnaire->description }}</p>
                <small class="text-muted d-block">
                    <i class="fas fa-clipboard-list"></i> {{ $questionnaire->questions ? $questionnaire->questions->count() : 0 }} Pertanyaan
                </small>
            </div>
        </div>

        @if($questionnaire->questions && $questionnaire->questions->count() > 0)
            <form action="{{ route('respondent.submit', $questionnaire) }}" method="POST" id="questionnaireForm">
                @csrf

                @foreach($questionnaire->questions ? $questionnaire->questions->sortBy('order') : collect() as $index => $question)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h6 class="card-subtitle mb-2">
                                    <span class="badge bg-secondary me-2">Pertanyaan {{ $index + 1 }}</span>
                                    <span class="badge bg-info">{{ $question->sdgGoal->title }}</span>
                                </h6>
                            </div>

                            <p class="card-text fw-bold mb-3">{{ $question->question_text }}</p>

                            @if(optional($question->questionOptions)->count() > 0)
                                <div class="question-options">
                                    @foreach($question->questionOptions ?? [] as $option)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio"
                                                   name="answers[{{ $question->id }}]"
                                                   id="option_{{ $question->id }}_{{ $loop->index }}"
                                                   value="{{ $option->option_text }}" required>
                                            <label class="form-check-label" for="option_{{ $question->id }}_{{ $loop->index }}">
                                                {{ $option->option_text }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($question->question_type === 'multiple_choice')
                                <div class="alert alert-warning">
                                    Pilihan ganda belum memiliki opsi.
                                </div>
                            @elseif($question->question_type === 'scale')
                                <div class="scale-options">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   name="answers[{{ $question->id }}]"
                                                   id="scale_{{ $question->id }}_{{ $i }}"
                                                   value="{{ $i }}" required>
                                            <label class="form-check-label" for="scale_{{ $question->id }}_{{ $i }}">
                                                {{ $i }}
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            @elseif($question->question_type === 'yes_no')
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio"
                                           name="answers[{{ $question->id }}]"
                                           id="yes_{{ $question->id }}"
                                           value="Ya" required>
                                    <label class="form-check-label" for="yes_{{ $question->id }}">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="answers[{{ $question->id }}]"
                                           id="no_{{ $question->id }}"
                                           value="Tidak" required>
                                    <label class="form-check-label" for="no_{{ $question->id }}">
                                        Tidak
                                    </label>
                                </div>
                            @else
                                <textarea class="form-control"
                                          name="answers[{{ $question->id }}]"
                                          rows="3" required
                                          placeholder="Tulis jawaban Anda di sini..."></textarea>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-paper-plane"></i> Kirim Jawaban
                        </button>
                        <p class="text-muted text-center small mt-3 mb-0">
                            Pastikan semua pertanyaan sudah dijawab sebelum mengirim
                        </p>
                    </div>
                </div>
            </form>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Kuesioner ini belum memiliki pertanyaan.
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Informasi Kuesioner</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Status</small>
                    @if($questionnaire->status === 'active')
                        <span class="badge bg-success">Aktif</span>
                    @elseif($questionnaire->status === 'draft')
                        <span class="badge bg-warning">Draft</span>
                    @else
                        <span class="badge bg-secondary">Ditutup</span>
                    @endif
                </div>

                @if($questionnaire->start_date)
                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Mulai</small>
                        {{ $questionnaire->start_date->format('d M Y H:i') }}
                    </div>
                @endif

                @if($questionnaire->end_date)
                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Berakhir</small>
                        {{ $questionnaire->end_date->format('d M Y H:i') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
