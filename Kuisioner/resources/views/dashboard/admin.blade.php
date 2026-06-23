@extends('layouts.app')

@section('title', 'Admin Dashboard - UNIMUS EduConnect')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h2>
    <a href="{{ route('admin.questionnaires.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Buat Kuesioner Baru
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Kuesioner</h5>
                <h2>{{ $questionnairesCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Kuesioner Aktif</h5>
                <h2>{{ $activeQuestionnaires }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Responden</h5>
                <h2>{{ $respondentsCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Tingkat Penyelesaian</h5>
                <h2>{{ $completionRate }}%</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Kuesioner</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Target</th>
                        <th>Status</th>
                        <th>Pertanyaan</th>
                        <th>Tanggal Mulai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($questionnairesCount > 0 ? \App\Models\Questionnaire::with('targetRole')->get() : [] as $q)
                        <tr>
                            <td>{{ $q->title }}</td>
                            <td><span class="badge bg-secondary">{{ $q->targetRole->name }}</span></td>
                            <td>
                                @if ($q->status === 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif ($q->status === 'draft')
                                    <span class="badge bg-warning">Draft</span>
                                @else
                                    <span class="badge bg-danger">Ditutup</span>
                                @endif
                            </td>
                            <td>{{ $q->questions->count() }}</td>
                            <td>{{ $q->start_date ? $q->start_date->format('d/m/Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('admin.questionnaires.show', $q) }}" class="btn btn-sm btn-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.questionnaires.edit', $q) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.questionnaires.destroy', $q) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox"></i> Belum ada kuesioner
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
