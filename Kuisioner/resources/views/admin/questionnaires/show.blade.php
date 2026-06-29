@extends('layouts.app')

@section('title', $questionnaire->title)

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('admin.questionnaires.index') }}" class="btn btn-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h2>{{ $questionnaire->title }}</h2>
        <p class="text-muted">{{ $questionnaire->description }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Kuesioner</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Target Responden:</strong>
                        <span class="badge bg-info">{{ $questionnaire->targetRole->name }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        @if($questionnaire->status === 'active')
                            <span class="badge bg-success">Aktif</span>
                        @elseif($questionnaire->status === 'draft')
                            <span class="badge bg-warning">Draft</span>
                        @else
                            <span class="badge bg-secondary">Ditutup</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Dibuat:</strong> {{ $questionnaire->created_at->format('d M Y H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Diperbarui:</strong> {{ $questionnaire->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Pertanyaan ({{ $questionnaire->questions->count() }})</h5>
                <a href="{{ route('admin.questionnaires.questions.create', $questionnaire) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pertanyaan
                </a>
            </div>
            <div class="card-body">
                @if($questionnaire->questions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>SDG Goal</th>
                                    <th>Tipe</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questionnaire->questions->sortBy('order') as $index => $question)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($question->question_text, 60) }}</td>
                                        <td>{{ $question->sdgGoal->title }}</td>
                                        <td><span class="badge bg-secondary">{{ $question->question_type }}</span></td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" style="display:inline;"
                                                      onsubmit="return confirm('Yakin ingin menghapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">Belum ada pertanyaan. <a href="{{ route('admin.questionnaires.questions.create', $questionnaire) }}">Tambah sekarang</a></p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">Statistik</h6>
                <div class="mb-2">
                    <small class="text-muted">Total Jawaban:</small>
                    <strong class="d-block">{{ $questionnaire->answers->count() }}</strong>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Total Responden:</small>
                    <strong class="d-block">{{ $questionnaire->answers->groupBy('user_id')->count() }}</strong>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Aksi</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.questionnaires.edit', $questionnaire) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.analytics', ['questionnaire' => $questionnaire->id]) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-chart-bar"></i> Lihat Analytics
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
