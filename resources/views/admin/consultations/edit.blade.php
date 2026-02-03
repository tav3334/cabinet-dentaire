@extends('admin.layouts.admin')

@section('title', 'Modifier consultation')
@section('page-title', 'Modifier la consultation')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.consultations.update', $consultation) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
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

                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type de consultation <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="first_visit" {{ old('type') == 'first_visit' ? 'selected' : '' }}>Première visite</option>
                                <option value="follow_up" {{ old('type', 'follow_up') == 'follow_up' ? 'selected' : '' }}>Suivi</option>
                                <option value="emergency" {{ old('type') == 'emergency' ? 'selected' : '' }}>Urgence</option>
                                <option value="control" {{ old('type') == 'control' ? 'selected' : '' }}>Contrôle</option>
                                <option value="treatment" {{ old('type') == 'treatment' ? 'selected' : '' }}>Traitement</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="consultation_date" class="form-label">Date de consultation <span class="text-danger">*</span></label>
                            <input type="date" name="consultation_date" id="consultation_date" class="form-control @error('consultation_date') is-invalid @enderror"
                                   value="{{ old('consultation_date', date('Y-m-d')) }}" required>
                            @error('consultation_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="consultation_time" class="form-label">Heure</label>
                            <input type="time" name="consultation_time" id="consultation_time" class="form-control @error('consultation_time') is-invalid @enderror"
                                   value="{{ old('consultation_time', date('H:i')) }}">
                            @error('consultation_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Motif de consultation -->
                    <div class="mb-3">
                        <label for="chief_complaint" class="form-label">Motif principal de consultation</label>
                        <textarea name="chief_complaint" id="chief_complaint" rows="2" class="form-control @error('chief_complaint') is-invalid @enderror"
                                  placeholder="Raison de la visite...">{{ old('chief_complaint') }}</textarea>
                        @error('chief_complaint')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Examen clinique -->
                    <h5 class="mt-4 mb-3 text-primary">Examen Clinique</h5>

                    <div class="mb-3">
                        <label for="clinical_examination" class="form-label">Examen clinique détaillé</label>
                        <textarea name="clinical_examination" id="clinical_examination" rows="3" class="form-control @error('clinical_examination') is-invalid @enderror"
                                  placeholder="Observations lors de l'examen...">{{ old('clinical_examination') }}</textarea>
                        @error('clinical_examination')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="oral_hygiene" class="form-label">Hygiène bucco-dentaire</label>
                            <textarea name="oral_hygiene" id="oral_hygiene" rows="2" class="form-control @error('oral_hygiene') is-invalid @enderror"
                                      placeholder="État de l'hygiène...">{{ old('oral_hygiene') }}</textarea>
                            @error('oral_hygiene')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="periodontal_status" class="form-label">État parodontal</label>
                            <textarea name="periodontal_status" id="periodontal_status" rows="2" class="form-control @error('periodontal_status') is-invalid @enderror"
                                      placeholder="État des gencives...">{{ old('periodontal_status') }}</textarea>
                            @error('periodontal_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Diagnostic -->
                    <h5 class="mt-4 mb-3 text-primary">Diagnostic & Plan de Traitement</h5>

                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Diagnostic</label>
                        <textarea name="diagnosis" id="diagnosis" rows="3" class="form-control @error('diagnosis') is-invalid @enderror"
                                  placeholder="Diagnostic établi...">{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="treatment_plan" class="form-label">Plan de traitement</label>
                        <textarea name="treatment_plan" id="treatment_plan" rows="3" class="form-control @error('treatment_plan') is-invalid @enderror"
                                  placeholder="Soins à effectuer...">{{ old('treatment_plan') }}</textarea>
                        @error('treatment_plan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prescriptions -->
                    <h5 class="mt-4 mb-3 text-primary">Prescriptions & Recommandations</h5>

                    <div class="mb-3">
                        <label for="prescriptions" class="form-label">Prescriptions médicamenteuses</label>
                        <textarea name="prescriptions" id="prescriptions" rows="3" class="form-control @error('prescriptions') is-invalid @enderror"
                                  placeholder="Médicaments prescrits...">{{ old('prescriptions') }}</textarea>
                        @error('prescriptions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="recommendations" class="form-label">Recommandations</label>
                        <textarea name="recommendations" id="recommendations" rows="2" class="form-control @error('recommendations') is-invalid @enderror"
                                  placeholder="Conseils donnés au patient...">{{ old('recommendations') }}</textarea>
                        @error('recommendations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="next_appointment_date" class="form-label">Prochain rendez-vous</label>
                            <input type="date" name="next_appointment_date" id="next_appointment_date" class="form-control @error('next_appointment_date') is-invalid @enderror"
                                   value="{{ old('next_appointment_date') }}">
                            @error('next_appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="notes" class="form-label">Notes générales</label>
                            <textarea name="notes" id="notes" rows="2" class="form-control @error('notes') is-invalid @enderror"
                                      placeholder="Notes additionnelles...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Vous serez automatiquement enregistré comme le praticien de cette consultation.
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.consultations.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer la consultation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
