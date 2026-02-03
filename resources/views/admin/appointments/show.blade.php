@extends('admin.layouts.admin')

@section('title', 'Détails du rendez-vous')
@section('page-title', 'Détails du rendez-vous')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-check me-2 text-primary"></i>
                    Rendez-vous #{{ $appointment->id }}
                </h5>
                <span class="badge badge-{{ $appointment->status_badge }} fs-6">
                    {{ $appointment->status_label }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Date et heure</h6>
                        <p class="fs-5 mb-0">
                            <i class="bi bi-calendar me-2 text-primary"></i>
                            {{ $appointment->appointment_date->format('d/m/Y') }}
                            @if($appointment->appointment_date->isToday())
                                <span class="badge bg-info ms-2">Aujourd'hui</span>
                            @endif
                        </p>
                        <p class="fs-5 mb-0 mt-2">
                            <i class="bi bi-clock me-2 text-primary"></i>
                            {{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') : 'Non spécifié' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Service demandé</h6>
                        @if($appointment->service)
                            <p class="fs-5 mb-0">
                                <i class="bi bi-gear me-2 text-primary"></i>
                                {{ $appointment->service->title }}
                            </p>
                        @else
                            <p class="text-muted">Non spécifié</p>
                        @endif
                    </div>
                </div>

                <hr class="my-4">

                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Patient</h6>
                        <p class="fs-5 mb-0">
                            <i class="bi bi-person me-2 text-primary"></i>
                            {{ $appointment->name }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Contact</h6>
                        <p class="mb-1">
                            <i class="bi bi-telephone me-2 text-primary"></i>
                            <a href="tel:{{ $appointment->phone }}">{{ $appointment->phone }}</a>
                        </p>
                    </div>
                </div>

                @if($appointment->message)
                    <hr class="my-4">
                    <h6 class="text-muted mb-2">Message du patient</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $appointment->message }}</p>
                    </div>
                @endif

                <hr class="my-4">

                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Créé le</h6>
                        <p class="mb-0">{{ $appointment->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Dernière modification</h6>
                        <p class="mb-0">{{ $appointment->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Actions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="bi bi-lightning me-2 text-warning"></i>
                    Actions rapides
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($appointment->status == 'pending')
                        <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-2"></i>Confirmer le rendez-vous
                            </button>
                        </form>
                    @endif

                    @if($appointment->status != 'canceled')
                        <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="canceled">
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-x-circle me-2"></i>Annuler le rendez-vous
                            </button>
                        </form>
                    @endif

                    @if($appointment->status == 'canceled')
                        <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-outline-warning w-100">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Remettre en attente
                            </button>
                        </form>
                    @endif

                    <hr>

                    <form action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                          method="POST"
                          onsubmit="return confirm('Supprimer ce rendez-vous ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contacter -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="bi bi-telephone me-2 text-primary"></i>
                    Contacter le patient
                </h6>
            </div>
            <div class="card-body">
                <a href="tel:{{ $appointment->phone }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="bi bi-telephone me-2"></i>Appeler
                </a>
                <a href="sms:{{ $appointment->phone }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-chat-text me-2"></i>Envoyer un SMS
                </a>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Retour à la liste
    </a>
</div>
@endsection
