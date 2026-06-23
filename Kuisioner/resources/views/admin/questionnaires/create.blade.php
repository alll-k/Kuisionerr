@extends('layouts.app')

@section('title', 'Buat Kuesioner')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-plus-circle"></i> Buat Kuesioner Baru</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Kuesioner</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.questionnaires.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Judul Kuesioner <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh: Evaluasi Implementasi SDGs">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" placeholder="Jelaskan tujuan kuesioner ini...">{{ old('description') }}</textarea>
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
                                <option value="{{ $role->id }}" {{ old('target_role_id') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('target_role_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">Pilih kategori sesuai sasaran evaluasi</small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Buat Kuesioner
                        </button>
                        <a href="{{ route('admin.questionnaires.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-lightbulb"></i> Tips</h5>
                <p class="card-text small">
                    Buat informasi dasar terlebih dahulu, kemudian tambahkan pertanyaan setelah kuesioner tersimpan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection