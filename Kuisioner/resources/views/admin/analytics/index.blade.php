@extends('layouts.app')

@section('title', 'Analitik & Laporan')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-chart-bar"></i> Analitik & Laporan</h2>
        <p class="text-muted">Statistik jawaban kuesioner SDGs</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted">Total Jawaban</h6>
                        <h3 class="text-primary">{{ $totalAnswers }}</h3>
                    </div>
                    <i class="fas fa-pen-fancy fa-3x text-primary opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted">Responden Unik</h6>
                        <h3 class="text-success">{{ $uniqueRespondents }}</h3>
                    </div>
                    <i class="fas fa-users fa-3x text-success opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted">Kuesioner</h6>
                        <h3 class="text-info">{{ $totalQuestionnaires }}</h3>
                    </div>
                    <i class="fas fa-list-check fa-3x text-info opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Distribusi Jawaban per SDG</h5>
            </div>
            <div class="card-body">
                <canvas id="sdgChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kuesioner Teratas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kuesioner</th>
                                <th>Jawaban</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topQuestionnaires as $q)
                                <tr>
                                    <td>{{ Str::limit($q->title, 40) }}</td>
                                    <td><span class="badge bg-primary">{{ $q->answers_count }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Responden Aktif</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Jawaban</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topRespondents as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td><span class="badge bg-secondary">{{ $user->role->name }}</span></td>
                                    <td><span class="badge bg-info">{{ $user->answers_count }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-download"></i> Export
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.export') }}" class="btn btn-primary">
                    <i class="fas fa-file-csv"></i> Export ke CSV
                </a>
                <a href="{{ route('admin.export.pdf') }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Export ke PDF
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Dummy chart - ganti dengan data aktual dari controller
    const ctx = document.getElementById('sdgChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['SDG 1', 'SDG 2', 'SDG 3', 'SDG 4', 'SDG 5'],
            datasets: [{
                label: 'Jumlah Jawaban',
                data: [12, 19, 3, 5, 2],
                backgroundColor: 'rgba(102, 126, 234, 0.5)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
