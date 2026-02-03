@extends('admin.layouts.admin')

@section('title', 'Corbeille')

@section('content')

<h3>Rendez-vous supprimés</h3>

<a href="{{ route('admin.appointments.index') }}" class="btn btn-primary mb-3">
    Retour
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Téléphone</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($appointments as $appointment)
        <tr>
            <td>{{ $appointment->name }}</td>
            <td>{{ $appointment->phone }}</td>
            <td>{{ $appointment->appointment_date }}</td>
            <td>
                <form method="POST" action="{{ route('admin.appointments.restore', $appointment->id) }}">
                    @csrf
                    <button class="btn btn-success btn-sm">Restaurer</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Corbeille vide</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
