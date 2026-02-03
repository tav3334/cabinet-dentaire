<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with('service');

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtre par date
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                             ->orderBy('appointment_time', 'desc')
                             ->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function show($id)
    {
        $appointment = Appointment::with(['service', 'patient'])->findOrFail($id);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,canceled',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $request->status]);

        $statusLabels = [
            'pending' => 'mis en attente',
            'confirmed' => 'confirmé',
            'canceled' => 'annulé',
        ];

        return redirect()->back()->with('success', "Rendez-vous {$statusLabels[$request->status]}.");
    }

    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Rendez-vous supprimé.');
    }

    public function trashed()
    {
        $appointments = Appointment::onlyTrashed()->with('service')->latest()->get();
        return view('admin.appointments.trashed', compact('appointments'));
    }

    public function restore($id)
    {
        Appointment::withTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with('success', 'Rendez-vous restauré.');
    }
}
