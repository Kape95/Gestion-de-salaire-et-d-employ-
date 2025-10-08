<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\User;
use App\Models\Departement;
use App\Models\Salaire;
use Carbon\Carbon;

class AppController extends Controller
{
    public function index()
    {
        // Statistiques de base
        $totalDepartements = Departement::count();
        $totalEmployers = Employer::count();
        $totalAdministrateurs = User::count();
        
        // Employés récents (5 derniers)
        $recentEmployers = Employer::with('departement')
            ->latest()
            ->take(5)
            ->get();
        
        // Statistiques avancées
        $stats = [
            'totalDepartements' => $totalDepartements,
            'totalEmployers' => $totalEmployers,
            'totalAdministrateurs' => $totalAdministrateurs,
            'recentEmployers' => $recentEmployers,
            'employersThisMonth' => Employer::whereMonth('created_at', Carbon::now()->month)->count(),
            'departementsThisMonth' => Departement::whereMonth('created_at', Carbon::now()->month)->count(),
            'totalSalaryThisMonth' => Employer::sum('montant_journalier') * 22, // Estimation basée sur 22 jours de travail
            'averageSalary' => Employer::avg('montant_journalier'),
            'topDepartments' => Departement::withCount('employers')
                ->orderBy('employers_count', 'desc')
                ->take(5)
                ->get(),
        ];
        
        return view('dashboard', $stats);
    }
}
