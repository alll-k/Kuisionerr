@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>
        <p class="text-muted">Selamat datang di panel admin UNIMUS EduConnect</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted">Total Kuesioner</h6>
                        <h3 class="text-primary">{{ $totalQuestionnaires }}</h3>
                    </div>
                    <i class="fas fa-list-check fa-3x text-primary opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted">Kuesioner Aktif</h6>
                        <h3 class="text-success">{{ $activeQuestionnaires }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-3x text-success opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted">Total Responden</h6>
                        <h3 class="text-info">{{ $totalRespondents }}</h3>
                    </div>
                    <i class="fas fa-users fa-3x text-info opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted">Jawaban Tercatat</h6>
                        <h3 class="text-warning">{{ $totalAnswers }}</h3>
                    </div>
                    <i class="fas fa-pen-fancy fa-3x text-warning opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kuesioner Terbaru</h5>
            </div>
            <div class="card-body">
                @if($recentQuestionnaires->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Target</th>
                                    <th>Status</th>
                                    <th>Pertanyaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentQuestionnaires as $q)
                                    <tr>
                                        <td><strong>{{ $q->title }}</strong></td>
                                        <td><span class="badge bg-secondary">{{ $q->targetRole->name }}</span></td>
                                        <td>
                                            @if($q->status === 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($q->status === 'draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @else
                                                <span class="badge bg-secondary">Ditutup</span>
                                            @endif
                                        </td>
                                        <td>{{ $q->questions->count() }} pertanyaan</td>
                                        <td>
                                            <a href="{{ route('admin.questionnaires.edit', $q) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Belum ada kuesioner. <a href="{{ route('admin.questionnaires.create') }}">Buat kuesioner baru</a></p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Akses Cepat</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.questionnaires.create') }}" class="btn btn-primary btn-block mb-2 w-100">
                    <i class="fas fa-plus"></i> Buat Kuesioner Baru
                </a>
                <a href="{{ route('admin.questionnaires.index') }}" class="btn btn-outline-primary btn-block mb-2 w-100">
                    <i class="fas fa-list"></i> Kelola Kuesioner
                </a>
                <a href="{{ route('admin.analytics') }}" class="btn btn-outline-primary btn-block w-100">
                    <i class="fas fa-chart-bar"></i> Lihat Analytics
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
