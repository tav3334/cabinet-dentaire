<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;

class AppointmentController extends Controller
{
   public function create()
{
    $services = Service::all(); // Ajoutez cette ligne
    return view('appointments.create', compact('services'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'service_id' => 'nullable|exists:services,id',
            'message' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'phone.required' => 'Le téléphone est obligatoire.',
            'appointment_date.required' => 'La date est obligatoire.',
            'appointment_date.after' => 'La date doit être ultérieure à aujourd\'hui.',
            'appointment_time.required' => 'Veuillez choisir une heure.',
        ]);

        Appointment::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'service_id' => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Votre demande de rendez-vous a été envoyée avec succès ! Nous vous contacterons pour confirmation.');
    }
}
