@extends('layouts.app')

@section('title', 'Kelola Kuesioner')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-list"></i> Kelola Kuesioner</h2>
    </div>
    <a href="{{ route('admin.questionnaires.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Kuesioner Baru
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Target Responden</th>
                        <th>Status</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questionnaires as $q)
                        <tr>
                            <td>
                                <strong>{{ $q->title }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($q->description, 60) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($q->targetRole->name) }}</span>
                            </td>
                            <td>
                                @if($q->status === 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($q->status === 'draft')
                                    <span class="badge bg-warning">Draft</span>
                                @else
                                    <span class="badge bg-secondary">Ditutup</span>
                                @endif
                            </td>
                            <td>{{ $q->questions->count() }}</td>
                            <td>{{ $q->answers->count() }}</td>
                            <td>{{ $q->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.questionnaires.edit', $q) }}" class="btn btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.questionnaires.show', $q) }}" class="btn btn-info" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.questionnaires.destroy', $q) }}" method="POST" style="display:inline;" 
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="text-muted">Belum ada kuesioner.</p>
                                <a href="{{ route('admin.questionnaires.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> Buat Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{ $questionnaires->links() }}
@endsection
