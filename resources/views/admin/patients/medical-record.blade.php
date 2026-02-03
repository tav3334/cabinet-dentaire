<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dossier Médical - {{ $patient->full_name }}
            </h2>
            <a href="{{ route('admin.patients.show', $patient) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Informations du patient -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $patient->full_name }}</h3>
                            <p class="mt-2">
                                <span class="font-semibold">Âge:</span> {{ $patient->age }} ans
                                <span class="mx-3">|</span>
                                <span class="font-semibold">Genre:</span> {{ ucfirst($patient->gender ?? 'N/A') }}
                            </p>
                            <p class="mt-1">
                                <span class="font-semibold">Email:</span> {{ $patient->email }}
                                <span class="mx-3">|</span>
                                <span class="font-semibold">Téléphone:</span> {{ $patient->phone }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm">Dossier créé le</p>
                            <p class="font-semibold">{{ $patient->created_at ? $patient->created_at->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-600">Total RDV</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total_appointments'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-600">Traitements</div>
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['total_treatments'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-600">En cours</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['active_treatments'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-600">Complétés</div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['completed_treatments'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-600">Consultations</div>
                    <div class="text-2xl font-bold text-indigo-600">{{ $stats['total_consultations'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="text-sm text-gray-600">Fichiers</div>
                    <div class="text-2xl font-bold text-pink-600">{{ $stats['total_files'] }}</div>
                </div>
            </div>

            <!-- Historique Médical & Allergies -->
            @if($patient->medical_history || $patient->allergies)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Informations Médicales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($patient->medical_history)
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Historique Médical</h4>
                            <div class="bg-gray-50 p-3 rounded text-sm">{{ $patient->medical_history }}</div>
                        </div>
                        @endif
                        @if($patient->allergies)
                        <div>
                            <h4 class="font-medium text-red-700 mb-2">⚠️ Allergies</h4>
                            <div class="bg-red-50 p-3 rounded text-sm text-red-800">{{ $patient->allergies }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Traitements -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Traitements</h3>
                        <a href="{{ route('admin.treatments.create', ['patient_id' => $patient->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            + Nouveau Traitement
                        </a>
                    </div>
                    @if($patient->treatments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dent</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progression</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coût</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($patient->treatments as $treatment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.treatments.show', $treatment) }}" class="text-blue-600 hover:underline">
                                                {{ $treatment->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $treatment->category_label }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $treatment->tooth_number ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($treatment->status === 'completed') bg-green-100 text-green-800
                                                @elseif($treatment->status === 'in_progress') bg-yellow-100 text-yellow-800
                                                @elseif($treatment->status === 'planned') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ $treatment->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $treatment->sessions_completed }}/{{ $treatment->sessions_required }} séances ({{ $treatment->progress_percentage }}%)
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $treatment->actual_cost ? number_format($treatment->actual_cost, 2) . ' €' : ($treatment->estimated_cost ? number_format($treatment->estimated_cost, 2) . ' € (est.)' : '-') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $treatment->planned_date ? $treatment->planned_date->format('d/m/Y') : '-' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Aucun traitement enregistré.</p>
                    @endif
                </div>
            </div>

            <!-- Consultations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Consultations</h3>
                        <a href="{{ route('admin.consultations.create', ['patient_id' => $patient->id]) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                            + Nouvelle Consultation
                        </a>
                    </div>
                    @if($patient->consultations->count() > 0)
                        <div class="space-y-4">
                            @foreach($patient->consultations as $consultation)
                            <div class="border rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-semibold">{{ $consultation->type_label }}</h4>
                                        <p class="text-sm text-gray-600">{{ $consultation->consultation_date->format('d/m/Y') }}</p>
                                    </div>
                                    <a href="{{ route('admin.consultations.show', $consultation) }}" class="text-blue-600 hover:underline text-sm">
                                        Voir détails →
                                    </a>
                                </div>
                                @if($consultation->chief_complaint)
                                <div class="mt-2">
                                    <span class="text-xs font-medium text-gray-500">Motif:</span>
                                    <p class="text-sm">{{ Str::limit($consultation->chief_complaint, 150) }}</p>
                                </div>
                                @endif
                                @if($consultation->diagnosis)
                                <div class="mt-2">
                                    <span class="text-xs font-medium text-gray-500">Diagnostic:</span>
                                    <p class="text-sm">{{ Str::limit($consultation->diagnosis, 150) }}</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Aucune consultation enregistrée.</p>
                    @endif
                </div>
            </div>

            <!-- Fichiers Médicaux -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Documents & Fichiers Médicaux</h3>
                        <a href="{{ route('admin.medical-files.create', ['patient_id' => $patient->id]) }}" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded text-sm">
                            + Ajouter Fichier
                        </a>
                    </div>
                    @if($patient->medicalFiles->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($patient->medicalFiles as $file)
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                            {{ $file->type_label }}
                                        </span>
                                        <h4 class="font-semibold mt-2">{{ $file->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $file->document_date ? $file->document_date->format('d/m/Y') : 'Sans date' }}</p>
                                        <p class="text-xs text-gray-500">{{ $file->file_size_formatted }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 flex space-x-2">
                                    <a href="{{ route('admin.medical-files.show', $file) }}" class="text-blue-600 hover:underline text-sm">
                                        Voir
                                    </a>
                                    <a href="{{ route('admin.medical-files.download', $file) }}" class="text-green-600 hover:underline text-sm">
                                        Télécharger
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Aucun fichier médical.</p>
                    @endif
                </div>
            </div>

            <!-- Rendez-vous récents -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Rendez-vous Récents</h3>
                    @if($patient->appointments->count() > 0)
                        <div class="space-y-2">
                            @foreach($patient->appointments->take(5) as $appointment)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                <div>
                                    <p class="font-medium">{{ $appointment->service ? $appointment->service->title : 'Service non spécifié' }}</p>
                                    <p class="text-sm text-gray-600">{{ $appointment->appointment_date->format('d/m/Y') }} à {{ $appointment->appointment_time->format('H:i') }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $appointment->status_label }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Aucun rendez-vous.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
