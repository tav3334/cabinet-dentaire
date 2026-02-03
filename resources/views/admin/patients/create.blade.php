@extends('admin.layouts.admin')

@section('title', 'Nouveau patient')
@section('page-title', 'Nouveau patient')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.patients.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-4 border-bottom pb-2">
                        <i class="bi bi-person me-2 text-primary"></i>
                        Informations personnelles
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('first_name') is-invalid @enderror"
                                   id="first_name"
                                   name="first_name"
                                   value="{{ old('first_name') }}"
                                   required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('last_name') is-invalid @enderror"
                                   id="last_name"
                                   name="last_name"
                                   value="{{ old('last_name') }}"
                                   required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="tel"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="date_of_birth" class="form-label">Date de naissance</label>
                            <input type="date"
                                   class="form-control @error('date_of_birth') is-invalid @enderror"
                                   id="date_of_birth"
                                   name="date_of_birth"
                                   value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Genre</label>
                            <select class="form-select @error('gender') is-invalid @enderror"
                                    id="gender"
                                    name="gender">
                                <option value="">-- Sélectionner --</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Homme</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femme</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h5 class="mb-4 border-bottom pb-2">
                        <i class="bi bi-geo-alt me-2 text-primary"></i>
                        Adresse
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label for="address" class="form-label">Adresse</label>
                            <input type="text"
                                   class="form-control @error('address') is-invalid @enderror"
                                   id="address"
                                   name="address"
                                   value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">Ville</label>
                            <input type="text"
                                   class="form-control @error('city') is-invalid @enderror"
                                   id="city"
                                   name="city"
                                   value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="postal_code" class="form-label">Code postal</label>
                            <input type="text"
                                   class="form-control @error('postal_code') is-invalid @enderror"
                                   id="postal_code"
                                   name="postal_code"
                                   value="{{ old('postal_code') }}">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h5 class="mb-4 border-bottom pb-2">
                        <i class="bi bi-heart-pulse me-2 text-primary"></i>
                        Informations médicales
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="medical_history" class="form-label">Antécédents médicaux</label>
                            <textarea class="form-control @error('medical_history') is-invalid @enderror"
                                      id="medical_history"
                                      name="medical_history"
                                      rows="3">{{ old('medical_history') }}</textarea>
                            @error('medical_history')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="allergies" class="form-label">Allergies</label>
                            <textarea class="form-control @error('allergies') is-invalid @enderror"
                                      id="allergies"
                                      name="allergies"
                                      rows="3">{{ old('allergies') }}</textarea>
                            @error('allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes"
                                      name="notes"
                                      rows="2">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg me-2"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
