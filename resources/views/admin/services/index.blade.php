@extends('admin.layouts.admin')

@section('title', 'Gestion des services')
@section('page-title', 'Gestion des services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Gérez les services proposés par votre cabinet</p>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Nouveau service
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($services->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td>
                                    @if($service->image)
                                        <img src="{{ asset('storage/'.$service->image) }}"
                                             alt="{{ $service->title }}"
                                             class="rounded"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $service->title }}</strong>
                                </td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($service->description, 100) }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.services.show', $service) }}"
                                       class="btn btn-sm btn-outline-info" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer ce service ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-gear fs-1 text-muted d-block mb-3"></i>
                <h5>Aucun service trouvé</h5>
                <p class="text-muted">Commencez par ajouter un nouveau service.</p>
                <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Ajouter un service
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
