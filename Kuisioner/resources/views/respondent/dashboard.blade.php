@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-home"></i> Dashboard</h2>
        <p class="text-muted">Selamat datang {{ Auth::user()->name }}!</p>
    </div>
</div>

@if(Auth::user()->role->name === 'mahasiswa')
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Kuesioner Tersedia</h6>
                            <h3 class="text-primary">{{ $availableQuestionnaires }}</h3>
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
                            <h6 class="card-title text-muted">Sudah Diisi</h6>
                            <h3 class="text-success">{{ $completedQuestionnaires }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-3x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif(Auth::user()->role->name === 'dosen')
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Kuesioner Tersedia</h6>
                            <h3 class="text-primary">{{ $availableQuestionnaires }}</h3>
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
                            <h6 class="card-title text-muted">Sudah Diisi</h6>
                            <h3 class="text-success">{{ $completedQuestionnaires }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-3x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kuesioner Aktif</h5>
            </div>
            <div class="card-body">
                @if($activeQuestionnaires->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Pertanyaan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeQuestionnaires as $q)
                                    @php
                                        $answered = $q->answers()->where('user_id', auth()->id())->exists();
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $q->title }}</strong></td>
                                        <td>{{ $q->questions->count() }} pertanyaan</td>
                                        <td>
                                            @if($answered)
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-warning">Belum</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$answered)
                                                <a href="{{ route('respondent.show', $q) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Isi
                                                </a>
                                            @else
                                                <a href="{{ route('respondent.show', $q) }}" class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">Tidak ada kuesioner aktif</p>
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
                <a href="{{ route('respondent.questionnaires') }}" class="btn btn-primary btn-block mb-2 w-100">
                    <i class="fas fa-clipboard-list"></i> Semua Kuesioner
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
