<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'confirmed_appointments' => Appointment::where('status', 'confirmed')->count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'total_patients' => Patient::count(),
            'total_services' => Service::count(),
        ];

        // Rendez-vous d'aujourd'hui
        $todayAppointments = Appointment::with('service')
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();

        // Rendez-vous en attente (les plus récents)
        $pendingAppointments = Appointment::with('service')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Rendez-vous des 7 prochains jours
        $upcomingAppointments = Appointment::with('service')
            ->whereBetween('appointment_date', [today(), today()->addDays(7)])
            ->where('status', '!=', 'canceled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(10)
            ->get();

        // Statistiques par mois (12 derniers mois)
        $monthlyStats = Appointment::select(
                DB::raw('MONTH(appointment_date) as month'),
                DB::raw('YEAR(appointment_date) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->where('appointment_date', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Rendez-vous par service
        $appointmentsByService = Appointment::select('service_id', DB::raw('COUNT(*) as total'))
            ->with('service')
            ->whereNotNull('service_id')
            ->groupBy('service_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Derniers patients ajoutés
        $recentPatients = Patient::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'todayAppointments',
            'pendingAppointments',
            'upcomingAppointments',
            'monthlyStats',
            'appointmentsByService',
            'recentPatients'
        ));
    }
}
