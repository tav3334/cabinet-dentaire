@extends('admin.layouts.admin')

@section('title', 'Nouveau rendez-vous')
@section('page-title', 'Créer un rendez-vous')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.appointments.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->full_name }} - {{ $patient->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Pas de patient?
                            <a href="{{ route('admin.patients.create') }}" target="_blank" class="text-primary">Créer un nouveau patient</a>
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="service_id" class="form-label">Service <span class="text-danger">*</span></label>
                        <select name="service_id" id="service_id" class="form-select @error('service_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="appointment_date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date"
                                   name="appointment_date"
                                   id="appointment_date"
                                   class="form-control @error('appointment_date') is-invalid @enderror"
                                   value="{{ old('appointment_date', date('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            @error('appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="appointment_time" class="form-label">Heure <span class="text-danger">*</span></label>
                            <input type="time"
                                   name="appointment_time"
                                   id="appointment_time"
                                   class="form-control @error('appointment_time') is-invalid @enderror"
                                   value="{{ old('appointment_time', '09:00') }}"
                                   required>
                            @error('appointment_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label">Durée (minutes)</label>
                        <input type="number"
                               name="duration"
                               id="duration"
                               class="form-control @error('duration') is-invalid @enderror"
                               value="{{ old('duration', 30) }}"
                               min="15"
                               step="15"
                               placeholder="30">
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Durée estimée de la consultation (15, 30, 45, 60 minutes...)</small>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="confirmed" {{ old('status', 'confirmed') == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Annulé</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message / Notes</label>
                        <textarea name="message"
                                  id="message"
                                  rows="3"
                                  class="form-control @error('message') is-invalid @enderror"
                                  placeholder="Notes sur le rendez-vous, raison de la visite...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Note:</strong> Le nom et téléphone du patient seront automatiquement remplis à partir du patient sélectionné.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Créer le rendez-vous
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
