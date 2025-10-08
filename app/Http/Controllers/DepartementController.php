<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Employer;
use App\Http\Requests\saveDepartementRequest;
use Exception;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::withCount('employers')
            ->with('employers')
            ->paginate(10);
            
        $totalEmployers = Employer::count();
        $totalSalary = Employer::sum('montant_journalier') * 22; // Estimation basée sur 22 jours de travail
        
        return view('departements.index', compact('departements', 'totalEmployers', 'totalSalary'));
    }

    public function create()
    {
        return view('departements.create');
    }

    public function edit(Departement $departement)
    {
        return view('departements.edit', compact('departement'));
    }

    // Action d'interaction avec la BD
    public function store(saveDepartementRequest $request)
    {
        try {
            $departement = new Departement();
            $departement->name = $request->name;
            $departement->save();
            
            return redirect()->route('departements.index')
                ->with('success', 'Département créé avec succès.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    public function update(Departement $departement, saveDepartementRequest $request)
    {
        try {
            $departement->name = $request->name;
            $departement->update();
            
            return redirect()->route('departements.index')
                ->with('success', 'Département mis à jour avec succès.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    public function delete(Departement $departement)
    {
        try {
            // Vérifier s'il y a des employés dans ce département
            if ($departement->employers()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Impossible de supprimer ce département car il contient des employés.');
            }
            
            $departement->delete();
            
            return redirect()->route('departements.index')
                ->with('success', 'Département supprimé avec succès.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }
}

