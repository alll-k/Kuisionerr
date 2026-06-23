@extends('layouts.app')

@section('title', 'Edit Kuesioner')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('admin.questionnaires.index') }}" class="btn btn-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h2><i class="fas fa-edit"></i> Edit Kuesioner</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Kuesioner</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.questionnaires.update', $questionnaire) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Judul Kuesioner <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $questionnaire->title) }}" required>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $questionnaire->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="target_role_id" class="form-label">Target Responden <span class="text-danger">*</span></label>
                        <select class="form-select @error('target_role_id') is-invalid @enderror" 
                                id="target_role_id" name="target_role_id" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $questionnaire->target_role_id == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('target_role_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ $questionnaire->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ $questionnaire->status == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="closed" {{ $questionnaire->status == 'closed' ? 'selected' : '' }}>Ditutup</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" 
                                   value="{{ $questionnaire->start_date ? $questionnaire->start_date->format('Y-m-d\TH:i') : '' }}">
                            @error('start_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="end_date" class="form-label">Tanggal Berakhir</label>
                            <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" 
                                   value="{{ $questionnaire->end_date ? $questionnaire->end_date->format('Y-m-d\TH:i') : '' }}">
                            @error('end_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.questionnaires.show', $questionnaire) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    <strong>Tips:</strong> Edit informasi dasar kuesioner di sini, dan kelola pertanyaan di halaman detail kuesioner.
                </p>
                <div class="mt-3">
                    <strong>Statistik:</strong>
                    <div class="mt-2">
                        <small class="d-block">Pertanyaan: <span class="badge bg-primary">{{ $questionnaire->questions->count() }}</span></small>
                        <small class="d-block">Jawaban: <span class="badge bg-success">{{ $questionnaire->answers->count() }}</span></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
