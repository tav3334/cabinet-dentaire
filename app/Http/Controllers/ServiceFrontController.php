<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceFrontController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('services.index', compact('services'));
    }
}
