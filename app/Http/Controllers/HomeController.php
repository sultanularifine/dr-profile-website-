<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user && $user->hasAnyRole(['Super Admin', 'Doctor', 'Receptionist', 'Admin'])) {
            return redirect()->route('dashboard');
        }

        // Unassigned/legacy accounts default to the patient area, not the admin dashboard.
        return redirect()->route('patient.dashboard');
    }
}
