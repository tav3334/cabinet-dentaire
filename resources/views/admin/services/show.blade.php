@extends('admin.layouts.admin')

@section('title', 'Détails du service')
@section('page-title', 'Détails du service')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
    </a>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row">
                    @if($service->image)
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <img src="{{ asset('storage/'.$service->image) }}"
                                 alt="{{ $service->title }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 300px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                    @else
                        <div class="col-12">
                    @endif
                            <h3 class="mb-3">{{ $service->title }}</h3>

                            <div class="mb-4">
                                <h6 class="text-muted">Description</h6>
                                <p class="text-dark">{{ $service->description }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Date de création</h6>
                                    <p>{{ $service->created_at ? $service->created_at->format('d/m/Y à H:i') : '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Dernière modification</h6>
                                    <p>{{ $service->updated_at ? $service->updated_at->format('d/m/Y à H:i') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>Modifier
                    </a>
                    <form action="{{ route('admin.services.destroy', $service) }}"
                          method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
