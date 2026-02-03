@extends('admin.layouts.admin')

@section('title', 'Ajouter un fichier médical')
@section('page-title', 'Uploader un fichier médical')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.medical-files.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Taille maximale:</strong> 10 MB par fichier
                        <br>
                        <strong>Formats acceptés:</strong> PDF, JPG, JPEG, PNG, GIF, DOC, DOCX
                    </div>

                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id', request('patient_id')) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier <span class="text-danger">*</span></label>
                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" required accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx">
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Maximum 10 MB</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type de document <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="xray" {{ old('type') == 'xray' ? 'selected' : '' }}>Radiographie</option>
                                <option value="scan" {{ old('type') == 'scan' ? 'selected' : '' }}>Scanner</option>
                                <option value="photo" {{ old('type') == 'photo' ? 'selected' : '' }}>Photo</option>
                                <option value="document" {{ old('type', 'document') == 'document' ? 'selected' : '' }}>Document</option>
                                <option value="prescription" {{ old('type') == 'prescription' ? 'selected' : '' }}>Ordonnance</option>
                                <option value="report" {{ old('type') == 'report' ? 'selected' : '' }}>Rapport</option>
                                <option value="consent" {{ old('type') == 'consent' ? 'selected' : '' }}>Consentement</option>
                                <option value="lab_result" {{ old('type') == 'lab_result' ? 'selected' : '' }}>Résultat labo</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="document_date" class="form-label">Date du document</label>
                            <input type="date" name="document_date" id="document_date" class="form-control @error('document_date') is-invalid @enderror"
                                   value="{{ old('document_date', date('Y-m-d')) }}">
                            @error('document_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" placeholder="Ex: Radiographie panoramique" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Description du document...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="consultation_id" class="form-label">Lier à une consultation</label>
                            <select name="consultation_id" id="consultation_id" class="form-select @error('consultation_id') is-invalid @enderror">
                                <option value="">Aucune</option>
                                @foreach($consultations as $consultation)
                                    <option value="{{ $consultation->id }}" {{ old('consultation_id') == $consultation->id ? 'selected' : '' }}>
                                        {{ $consultation->patient->full_name }} - {{ $consultation->consultation_date->format('d/m/Y') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('consultation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="treatment_id" class="form-label">Lier à un traitement</label>
                            <select name="treatment_id" id="treatment_id" class="form-select @error('treatment_id') is-invalid @enderror">
                                <option value="">Aucun</option>
                                @foreach($treatments as $treatment)
                                    <option value="{{ $treatment->id }}" {{ old('treatment_id') == $treatment->id ? 'selected' : '' }}>
                                        {{ $treatment->patient->full_name }} - {{ $treatment->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('treatment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="Notes additionnelles...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.medical-files.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i>Uploader le fichier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
