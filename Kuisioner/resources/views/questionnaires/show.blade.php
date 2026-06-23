@extends('layouts.app')

@section('title', $questionnaire->title . ' - UNIMUS EduConnect')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ $questionnaire->title }}</h2>
    <a href="{{ route('questionnaires.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5>Instruksi</h5>
                <p>{{ $questionnaire->description }}</p>
                
                <hr>
                
                <form id="questionnaireForm">
                    @csrf
                    @forelse ($questions as $index => $question)
                        <div class="question-item mb-4" data-question-id="{{ $question->id }}">
                            <h6 class="mb-3">
                                <span class="badge bg-primary">{{ $index + 1 }}/{{ $questions->count() }}</span>
                                {{ $question->question_text }}
                            </h6>
                            
                            @if ($question->question_type === 'text')
                                <textarea class="form-control answer-input" name="answers[{{ $question->id }}]" rows="3" data-question-id="{{ $question->id }}">{{ $userAnswers[$question->id] ?? '' }}</textarea>
                            @elseif ($question->question_type === 'yes_no')
                                <div class="form-check">
                                    <input class="form-check-input answer-input" type="radio" name="answers[{{ $question->id }}]" id="yes_{{ $question->id }}" value="Ya" data-question-id="{{ $question->id }}" {{ ($userAnswers[$question->id] ?? null) === 'Ya' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="yes_{{ $question->id }}">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input answer-input" type="radio" name="answers[{{ $question->id }}]" id="no_{{ $question->id }}" value="Tidak" data-question-id="{{ $question->id }}" {{ ($userAnswers[$question->id] ?? null) === 'Tidak' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="no_{{ $question->id }}">Tidak</label>
                                </div>
                            @elseif ($question->question_type === 'scale')
                                <div class="d-flex gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="form-check">
                                            <input class="form-check-input answer-input" type="radio" name="answers[{{ $question->id }}]" id="scale_{{ $question->id }}_{{ $i }}" value="{{ $i }}" data-question-id="{{ $question->id }}" {{ ($userAnswers[$question->id] ?? null) === (string)$i ? 'checked' : '' }}>
                                            <label class="form-check-label" for="scale_{{ $question->id }}_{{ $i }}">{{ $i }}</label>
                                        </div>
                                    @endfor
                                </div>
                            @elseif ($question->question_type === 'multiple_choice')
                                @if ($question->options)
                                    @foreach ($question->options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input answer-input" type="radio" name="answers[{{ $question->id }}]" id="option_{{ $question->id }}_{{ $loop->index }}" value="{{ $option }}" data-question-id="{{ $question->id }}" {{ ($userAnswers[$question->id] ?? null) === $option ? 'checked' : '' }}>
                                            <label class="form-check-label" for="option_{{ $question->id }}_{{ $loop->index }}">{{ $option }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    @empty
                        <div class="alert alert-info">Belum ada pertanyaan</div>
                    @endforelse
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-success" onclick="submitQuestionnaire()">
                            <i class="fas fa-check"></i> Serahkan Kuesioner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi SDGs</h5>
            </div>
            <div class="card-body">
                @foreach ($questions->groupBy('sdg_goal_id') as $sdgId => $sdgQuestions)
                    @php $sdgGoal = $sdgQuestions[0]->sdgGoal; @endphp
                    <div class="mb-3">
                        <h6 class="text-primary">{{ $sdgGoal->title }}</h6>
                        <small class="text-muted">{{ $sdgGoal->description }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('questionnaireForm').addEventListener('submit', function(e) {
    e.preventDefault();
    saveAnswers();
});

function saveAnswers() {
    const formData = new FormData(document.getElementById('questionnaireForm'));
    const answers = Object.fromEntries(formData);
    
    Object.entries(answers).forEach(([key, value]) => {
        if (key.startsWith('answers[')) {
            const questionId = key.match(/\[(\d+)\]/)[1];
            fetch('{{ route('questionnaires.save-answer', [$questionnaire->id, '__QID__']) }}'.replace('__QID__', questionId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ answer: value })
            }).catch(err => console.error(err));
        }
    });
}

function submitQuestionnaire() {
    saveAnswers();
    setTimeout(() => {
        if (confirm('Apakah Anda yakin ingin menyelesaikan kuesioner ini?')) {
            window.location.href = '{{ route('questionnaires.submit', $questionnaire) }}';
        }
    }, 500);
}
</script>
@endsection
