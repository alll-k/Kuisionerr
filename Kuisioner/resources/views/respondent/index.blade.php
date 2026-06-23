@extends('layouts.app')

@section('title', 'Kuesioner Saya')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-clipboard-list"></i> Kuesioner Saya</h2>
        <p class="text-muted">Daftar kuesioner yang dapat Anda isi</p>
    </div>
</div>

<div class="row">
    @forelse($questionnaires as $q)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $q->title }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($q->description, 100) }}</p>
                    
                    <div class="mb-3">
                        <span class="badge bg-info">{{ $q->questions->count() }} Pertanyaan</span>
                        @if($q->status === 'active')
                            <span class="badge bg-success">Aktif</span>
                        @elseif($q->status === 'draft')
                            <span class="badge bg-warning">Draft</span>
                        @else
                            <span class="badge bg-secondary">Ditutup</span>
                        @endif
                    </div>
                    
                    @php
                        $userHasAnswered = $q->answers()->where('user_id', auth()->id())->exists();
                    @endphp
                    
                    @if($userHasAnswered)
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle"></i> Anda telah mengisi kuesioner ini
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white">
                    @if($q->status === 'active' && !$userHasAnswered)
                        <a href="{{ route('respondent.show', $q) }}" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-edit"></i> Isi Kuesioner
                        </a>
                    @elseif($q->status === 'active' && $userHasAnswered)
                        <a href="{{ route('respondent.show', $q) }}" class="btn btn-secondary btn-sm w-100">
                            <i class="fas fa-eye"></i> Lihat Jawaban
                        </a>
                    @else
                        <button class="btn btn-secondary btn-sm w-100" disabled>
                            <i class="fas fa-ban"></i> Tidak Aktif
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Tidak ada kuesioner untuk Anda saat ini.
            </div>
        </div>
    @endforelse
</div>
@endsection
