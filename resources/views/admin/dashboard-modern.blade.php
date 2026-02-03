@extends('admin.layouts.admin-modern')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')

<!-- Statistiques Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Aujourd'hui -->
    <x-stat-card
        title="Aujourd'hui"
        :value="$stats['today_appointments']"
        icon="bi bi-calendar-day"
        gradient="primary"
        :trend="null">
    </x-stat-card>

    <!-- En attente -->
    <x-stat-card
        title="En attente"
        :value="$stats['pending_appointments']"
        icon="bi bi-hourglass-split"
        gradient="warning"
        :trend="null">
    </x-stat-card>

    <!-- Confirmés -->
    <x-stat-card
        title="Confirmés"
        :value="$stats['confirmed_appointments']"
        icon="bi bi-check-circle"
        gradient="success"
        :trend="null">
    </x-stat-card>

    <!-- Total Patients -->
    <x-stat-card
        title="Patients"
        :value="$stats['total_patients']"
        icon="bi bi-people"
        gradient="info"
        :trend="null">
    </x-stat-card>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    <!-- Rendez-vous d'aujourd'hui -->
    <x-card class="h-full">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center mr-3">
                    <i class="bi bi-calendar-check text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Rendez-vous aujourd'hui</h3>
            </div>
            <x-badge variant="primary">{{ $todayAppointments->count() }}</x-badge>
        </div>

        @if($todayAppointments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Heure</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Patient</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Service</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($todayAppointments as $apt)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4">
                                    <span class="font-bold text-gray-900">
                                        {{ $apt->appointment_time ? \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-gray-700">{{ $apt->name }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $apt->service->title ?? '-' }}</td>
                                <td class="py-4 px-4">
                                    <x-badge :variant="$apt->status" dot>
                                        {{ $apt->status_label }}
                                    </x-badge>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-calendar-x text-5xl text-gray-400"></i>
                </div>
                <p class="text-gray-500">Aucun rendez-vous aujourd'hui</p>
            </div>
        @endif
    </x-card>

    <!-- Rendez-vous en attente -->
    <x-card class="h-full">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl flex items-center justify-center mr-3">
                    <i class="bi bi-hourglass-split text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">En attente de confirmation</h3>
            </div>
            <a href="{{ route('admin.appointments.index') }}?status=pending" class="text-sm font-medium text-purple-600 hover:text-purple-800 transition-colors">
                Voir tout →
            </a>
        </div>

        @if($pendingAppointments->count() > 0)
            <div class="space-y-4">
                @foreach($pendingAppointments as $apt)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200 hover:shadow-md transition-all">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $apt->name }}</p>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="bi bi-calendar mr-1"></i>
                                {{ $apt->appointment_date->format('d/m/Y') }}
                                @if($apt->appointment_time)
                                    à {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <form action="{{ route('admin.appointments.updateStatus', $apt->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors" title="Confirmer">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.appointments.show', $apt->id) }}" class="p-2 bg-purple-100 hover:bg-purple-200 text-purple-600 rounded-lg transition-colors">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-check-circle text-5xl text-green-500"></i>
                </div>
                <p class="text-gray-500">Aucun rendez-vous en attente</p>
            </div>
        @endif
    </x-card>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Prochains rendez-vous -->
    <div class="lg:col-span-2">
        <x-card>
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-cyan-700 rounded-xl flex items-center justify-center mr-3">
                    <i class="bi bi-calendar-week text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Prochains rendez-vous (7 jours)</h3>
            </div>

            @if($upcomingAppointments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Date</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Heure</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Patient</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Téléphone</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Service</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($upcomingAppointments as $apt)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4 text-gray-700">{{ $apt->appointment_date->format('d/m/Y') }}</td>
                                    <td class="py-4 px-4 font-semibold text-gray-900">
                                        {{ $apt->appointment_time ? \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') : '-' }}
                                    </td>
                                    <td class="py-4 px-4 text-gray-700">{{ $apt->name }}</td>
                                    <td class="py-4 px-4 text-gray-600">{{ $apt->phone }}</td>
                                    <td class="py-4 px-4 text-gray-700">{{ $apt->service->title ?? '-' }}</td>
                                    <td class="py-4 px-4">
                                        <x-badge :variant="$apt->status" dot>
                                            {{ $apt->status_label }}
                                        </x-badge>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-calendar-x text-5xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">Aucun rendez-vous prévu</p>
                </div>
            @endif
        </x-card>
    </div>

    <!-- Colonne de droite -->
    <div class="space-y-6">

        <!-- Services populaires -->
        <x-card>
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl flex items-center justify-center mr-3">
                    <i class="bi bi-star text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Services populaires</h3>
            </div>

            @if($appointmentsByService->count() > 0)
                <div class="space-y-3">
                    @foreach($appointmentsByService as $item)
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl hover:shadow-md transition-all">
                            <span class="text-gray-700 font-medium">{{ $item->service->title ?? 'Service supprimé' }}</span>
                            <x-badge variant="primary">{{ $item->total }}</x-badge>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Pas encore de données</p>
                </div>
            @endif
        </x-card>

        <!-- Nouveaux patients -->
        <x-card>
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-xl flex items-center justify-center mr-3">
                        <i class="bi bi-person-plus text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Nouveaux patients</h3>
                </div>
                <a href="{{ route('admin.patients.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-800 transition-colors">
                    Voir tout →
                </a>
            </div>

            @if($recentPatients->count() > 0)
                <div class="space-y-3">
                    @foreach($recentPatients as $patient)
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                {{ substr($patient->full_name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $patient->full_name }}</p>
                                <p class="text-xs text-gray-500">{{ $patient->created_at ? $patient->created_at->diffForHumans() : 'Récemment' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Aucun patient enregistré</p>
                </div>
            @endif
        </x-card>

    </div>

</div>

@endsection

@push('scripts')
<script>
// Animations on load
document.addEventListener('DOMContentLoaded', function() {
    // Animate stat cards
    const statCards = document.querySelectorAll('[class*="stat-card"]');
    statCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);
    });
});
</script>
@endpush
