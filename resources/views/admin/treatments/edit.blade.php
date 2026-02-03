@extends('admin.layouts.admin')

@section('title', 'Modifier le traitement')
@section('page-title', 'Modifier le traitement')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.treatments.update', $treatment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id', $treatment->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Titre du traitement <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $treatment->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Catégorie <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="consultation" {{ old('category', $treatment->category) == 'consultation' ? 'selected' : '' }}>Consultation</option>
                                <option value="preventive" {{ old('category', $treatment->category) == 'preventive' ? 'selected' : '' }}>Préventif</option>
                                <option value="restorative" {{ old('category', $treatment->category) == 'restorative' ? 'selected' : '' }}>Restauration</option>
                                <option value="endodontic" {{ old('category', $treatment->category) == 'endodontic' ? 'selected' : '' }}>Endodontie</option>
                                <option value="periodontic" {{ old('category', $treatment->category) == 'periodontic' ? 'selected' : '' }}>Parodontie</option>
                                <option value="surgery" {{ old('category', $treatment->category) == 'surgery' ? 'selected' : '' }}>Chirurgie</option>
                                <option value="prosthetic" {{ old('category', $treatment->category) == 'prosthetic' ? 'selected' : '' }}>Prothèse</option>
                                <option value="orthodontic" {{ old('category', $treatment->category) == 'orthodontic' ? 'selected' : '' }}>Orthodontie</option>
                                <option value="cosmetic" {{ old('category', $treatment->category) == 'cosmetic' ? 'selected' : '' }}>Esthétique</option>
                                <option value="emergency" {{ old('category', $treatment->category) == 'emergency' ? 'selected' : '' }}>Urgence</option>
                                <option value="other" {{ old('category', $treatment->category) == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tooth_number" class="form-label">Numéro de dent</label>
                            <input type="text" name="tooth_number" id="tooth_number" class="form-control @error('tooth_number') is-invalid @enderror"
                                   value="{{ old('tooth_number', $treatment->tooth_number) }}">
                            @error('tooth_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $treatment->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="planned" {{ old('status', $treatment->status) == 'planned' ? 'selected' : '' }}>Planifié</option>
                                <option value="in_progress" {{ old('status', $treatment->status) == 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="completed" {{ old('status', $treatment->status) == 'completed' ? 'selected' : '' }}>Terminé</option>
                                <option value="on_hold" {{ old('status', $treatment->status) == 'on_hold' ? 'selected' : '' }}>En attente</option>
                                <option value="cancelled" {{ old('status', $treatment->status) == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="planned_date" class="form-label">Date planifiée</label>
                            <input type="date" name="planned_date" id="planned_date" class="form-control @error('planned_date') is-invalid @enderror"
                                   value="{{ old('planned_date', $treatment->planned_date?->format('Y-m-d')) }}">
                            @error('planned_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="sessions_required" class="form-label">Séances requises <span class="text-danger">*</span></label>
                            <input type="number" name="sessions_required" id="sessions_required" class="form-control @error('sessions_required') is-invalid @enderror"
                                   value="{{ old('sessions_required', $treatment->sessions_required) }}" min="1" required>
                            @error('sessions_required')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="sessions_completed" class="form-label">Séances complétées</label>
                            <input type="number" name="sessions_completed" id="sessions_completed" class="form-control @error('sessions_completed') is-invalid @enderror"
                                   value="{{ old('sessions_completed', $treatment->sessions_completed) }}" min="0">
                            @error('sessions_completed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="estimated_cost" class="form-label">Coût estimé (€)</label>
                            <input type="number" step="0.01" name="estimated_cost" id="estimated_cost" class="form-control @error('estimated_cost') is-invalid @enderror"
                                   value="{{ old('estimated_cost', $treatment->estimated_cost) }}">
                            @error('estimated_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="actual_cost" class="form-label">Coût réel (€)</label>
                            <input type="number" step="0.01" name="actual_cost" id="actual_cost" class="form-control @error('actual_cost') is-invalid @enderror"
                                   value="{{ old('actual_cost', $treatment->actual_cost) }}">
                            @error('actual_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="completed_date" class="form-label">Date de complétion</label>
                            <input type="date" name="completed_date" id="completed_date" class="form-control @error('completed_date') is-invalid @enderror"
                                   value="{{ old('completed_date', $treatment->completed_date?->format('Y-m-d')) }}">
                            @error('completed_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $treatment->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.treatments.show', $treatment) }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
