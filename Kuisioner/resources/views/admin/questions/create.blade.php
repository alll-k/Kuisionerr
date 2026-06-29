@extends('layouts.app')

@section('title', 'Tambah Pertanyaan')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-question-circle"></i> Tambah Pertanyaan</h2>
                <p class="text-muted mb-0">Tambah pertanyaan ke kuesioner <strong>{{ $questionnaire->title }}</strong> untuk target role <span class="badge bg-info">{{ ucfirst($questionnaire->targetRole->name) }}</span>.</p>
            </div>
            <a href="{{ route('admin.questionnaires.show', $questionnaire) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Kuesioner
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Form Tambah Pertanyaan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.questionnaires.questions.store', $questionnaire) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="question_text" class="form-label">Teks Pertanyaan</label>
                        <textarea id="question_text" name="question_text" rows="3" class="form-control @error('question_text') is-invalid @enderror" required>{{ old('question_text') }}</textarea>
                        @error('question_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="sdg_goal_id" class="form-label">SDG Goal</label>
                            <select id="sdg_goal_id" name="sdg_goal_id" class="form-select @error('sdg_goal_id') is-invalid @enderror" required>
                                <option value="">Pilih SDG Goal</option>
                                @foreach($sdgGoals as $goal)
                                    <option value="{{ $goal->id }}" {{ old('sdg_goal_id') == $goal->id ? 'selected' : '' }}>
                                        {{ $goal->number }}. {{ $goal->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sdg_goal_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="question_type" class="form-label">Tipe Pertanyaan</label>
                            <select id="question_type" name="type" class="form-select @error('type') is-invalid @enderror" onchange="toggleOptions()" required>
                                <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Teks Bebas</option>
                                <option value="multiple_choice" {{ old('type') == 'multiple_choice' ? 'selected' : '' }}>Pilihan Ganda</option>
                                <option value="scale" {{ old('type') == 'scale' ? 'selected' : '' }}>Skala</option>
                                <option value="yes_no" {{ old('type') == 'yes_no' ? 'selected' : '' }}>Ya / Tidak</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @php
                        $showOptions = old('type') === 'multiple_choice';
                        $oldOptions = old('options', ['']);
                    @endphp

                    <div id="options_area" class="mt-3" style="display: {{ $showOptions ? 'block' : 'none' }};">
                        <label class="form-label">Pilihan Jawaban</label>
                        <div id="options_container">
                            @if($showOptions)
                                @foreach($oldOptions as $option)
                                    <input type="text" name="options[]" class="form-control mb-2" placeholder="Opsi {{ $loop->iteration }}" value="{{ $option }}">
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addOption()">
                            <i class="fas fa-plus"></i> Tambah Pilihan
                        </button>
                        @error('options')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Pertanyaan
                        </button>
                        <a href="{{ route('admin.questionnaires.show', $questionnaire) }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleOptions() {
        const type = document.getElementById('question_type').value;
        const optionsArea = document.getElementById('options_area');
        const enabled = type === 'multiple_choice';

        optionsArea.style.display = enabled ? 'block' : 'none';

        document.querySelectorAll('#options_container input[name="options[]"]').forEach(input => {
            input.disabled = !enabled;
            if (!enabled) {
                input.value = '';
            }
        });
    }

    function addOption() {
        const container = document.getElementById('options_container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'options[]';
        input.className = 'form-control mb-2';
        input.placeholder = 'Opsi Tambahan';
        container.appendChild(input);
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleOptions();
    });
</script>
@endsection
