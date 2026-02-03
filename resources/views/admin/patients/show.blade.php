@extends('admin.layouts.admin')

@section('title', 'Fiche patient')
@section('page-title', 'Fiche patient')

@section('content')
<div class="row">
    <!-- Informations du patient -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                     style="width: 80px; height: 80px; font-size: 1.5rem;">
                    {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                </div>
                <h4 class="mb-1">{{ $patient->full_name }}</h4>
                @if($patient->age)
                    <p class="text-muted mb-3">{{ $patient->age }} ans</p>
                @endif

                <div class="d-flex justify-content-center gap-2 mb-3">
                    <a href="{{ route('admin.patients.medical-record', $patient) }}" class="btn btn-success">
                        <i class="bi bi-file-medical me-1"></i>Dossier Médical
                    </a>
                    <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Modifier
                    </a>
                    <form action="{{ route('admin.patients.destroy', $patient) }}"
                          method="POST"
                          onsubmit="return confirm('Supprimer ce patient ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="bi bi-envelope me-2 text-muted"></i>Email</span>
                    <span>{{ $patient->email }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="bi bi-telephone me-2 text-muted"></i>Téléphone</span>
                    <span>{{ $patient->phone }}</span>
                </li>
                @if($patient->date_of_birth)
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="bi bi-calendar me-2 text-muted"></i>Naissance</span>
                        <span>{{ $patient->date_of_birth->format('d/m/Y') }}</span>
                    </li>
                @endif
                @if($patient->gender)
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="bi bi-person me-2 text-muted"></i>Genre</span>
                        <span>{{ $patient->gender == 'male' ? 'Homme' : ($patient->gender == 'female' ? 'Femme' : 'Autre') }}</span>
                    </li>
                @endif
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="bi bi-calendar-plus me-2 text-muted"></i>Inscrit le</span>
                    <span>{{ $patient->created_at->format('d/m/Y') }}</span>
                </li>
            </ul>
        </div>

        @if($patient->address || $patient->city)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="bi bi-geo-alt me-2 text-primary"></i>Adresse
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        {{ $patient->address }}<br>
                        @if($patient->postal_code || $patient->city)
                            {{ $patient->postal_code }} {{ $patient->city }}
                        @endif
                    </p>
                </div>
            </div>
        @endif

        @if($patient->medical_history || $patient->allergies)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="bi bi-heart-pulse me-2 text-danger"></i>Informations médicales
                    </h6>
                </div>
                <div class="card-body">
                    @if($patient->allergies)
                        <div class="mb-3">
                            <strong class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Allergies</strong>
                            <p class="mb-0 mt-1">{{ $patient->allergies }}</p>
                        </div>
                    @endif
                    @if($patient->medical_history)
                        <div>
                            <strong>Antécédents médicaux</strong>
                            <p class="mb-0 mt-1">{{ $patient->medical_history }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Historique des rendez-vous -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-check me-2 text-primary"></i>
                    Historique des rendez-vous
                </h5>
                <span class="badge bg-primary">{{ $patient->appointments->count() }} rendez-vous</span>
            </div>
            <div class="card-body">
                @if($patient->appointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Service</th>
                                    <th>Statut</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patient->appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                                        <td>{{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') : '-' }}</td>
                                        <td>{{ $appointment->service->title ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $appointment->status_badge }}">
                                                {{ $appointment->status_label }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($appointment->message)
                                                <small class="text-muted">{{ Str::limit($appointment->message, 50) }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                        <p>Aucun rendez-vous enregistré pour ce patient.</p>
                    </div>
                @endif
            </div>
        </div>

        @if($patient->notes)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="bi bi-sticky me-2 text-warning"></i>Notes
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $patient->notes }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
