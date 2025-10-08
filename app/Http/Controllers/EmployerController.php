<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Departement;
use App\Http\Requests\StoreEmployeRequest;
use App\Http\Requests\UpdateEmployerRequest;
use Exception;

/**
 * ===========================================
 * CONTRÔLEUR DE GESTION DES EMPLOYÉS
 * ===========================================
 * 
 * Ce contrôleur gère toutes les opérations CRUD (Create, Read, Update, Delete)
 * liées aux employés de l'entreprise.
 * 
 * Fonctionnalités :
 * - Affichage de la liste des employés avec pagination
 * - Création de nouveaux employés
 * - Modification des informations d'employés existants
 * - Suppression d'employés
 * - Gestion des relations avec les départements
 * 
 * @author [Votre Nom]
 * @version 1.0
 */
class EmployerController extends Controller
{
    /**
     * ===========================================
     * AFFICHAGE DE LA LISTE DES EMPLOYÉS
     * ===========================================
     * 
     * Cette méthode récupère tous les employés avec leurs départements associés
     * et les affiche dans une vue paginée (10 employés par page).
     * 
     * @return \Illuminate\View\View Vue de la liste des employés
     */
    public function index()
    {
        // Récupération des employés avec leurs départements (eager loading pour optimiser les performances)
        $employers = Employer::with('departement')->paginate(10);
        
        // Récupération de tous les départements pour les filtres
        $departements = Departement::all();
        
        // Statistiques pour les cartes
        $stats = [
            'totalEmployers' => Employer::count(),
            'activeEmployers' => Employer::count(), // Tous les employés sont considérés comme actifs
            'averageSalary' => Employer::avg('montant_journalier'),
            'totalSalary' => Employer::sum('montant_journalier'),
            'newThisMonth' => Employer::where('created_at', '>=', now()->startOfMonth())->count(),
        ];
        
        // Retour de la vue avec les données
        return view('employers.index', compact('employers', 'departements', 'stats'));
    }

    public function create()
    {
        $departements = Departement::all();
        return view('employers.create', compact('departements'));
    }

    public function edit(Employer $employer)
    {
        $departements = Departement::all();
        
        return view('employers.edit', compact('employer', 'departements'));
    }

    /**
     * ===========================================
     * CRÉATION D'UN NOUVEL EMPLOYÉ
     * ===========================================
     * 
     * Cette méthode crée un nouvel employé en utilisant les données validées
     * du formulaire. Elle inclut une gestion d'erreur robuste.
     * 
     * @param StoreEmployeRequest $request Données validées du formulaire
     * @return \Illuminate\Http\RedirectResponse Redirection avec message de succès/erreur
     */
    public function store(StoreEmployeRequest $request)
    {
        try {
            // Récupération des données validées
            $data = $request->validated();
            
            // Traitement des dates vides
            if (empty($data['date_naissance'])) {
                $data['date_naissance'] = null;
            }
            
            if (empty($data['date_embauche'])) {
                $data['date_embauche'] = null;
            }
            
            // Création de l'employé avec les données traitées
            $employer = Employer::create($data);

            // Vérification de la création réussie
            if ($employer) {
                return redirect()->route('employers.index')
                    ->with('success', 'Employé créé avec succès.');
            }
            
            // Gestion du cas où la création échoue
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de l\'employé.');
        } catch (Exception $e) {
            // Gestion des exceptions avec message d'erreur détaillé
            return redirect()->back()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * ===========================================
     * MISE À JOUR D'UN EMPLOYÉ EXISTANT
     * ===========================================
     * 
     * Cette méthode met à jour les informations d'un employé existant.
     * Elle traite spécifiquement les champs de date pour éviter les erreurs
     * de format et gère les valeurs vides.
     * 
     * @param UpdateEmployerRequest $request Données validées du formulaire
     * @param Employer $employer Employé à modifier
     * @return \Illuminate\Http\RedirectResponse Redirection avec message de succès/erreur
     */
    public function update(UpdateEmployerRequest $request, Employer $employer)
    {
        try {
            // Récupération des données validées par la classe de validation
            $data = $request->validated();
            
            // Traitement spécial des champs de date
            // Si les champs de date sont vides, on les définit comme null
            // pour éviter les erreurs de format de date dans la base de données
            if (empty($data['date_naissance'])) {
                $data['date_naissance'] = null;
            }
            
            if (empty($data['date_embauche'])) {
                $data['date_embauche'] = null;
            }
            
            // Mise à jour de l'employé avec les données traitées
            $employer->update($data);

            // Redirection avec message de succès
            return redirect()->route('employers.index')
                ->with('success', 'Employé mis à jour avec succès.');
        } catch (Exception $e) {
            // Gestion des exceptions avec message d'erreur détaillé
            return redirect()->back()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * ===========================================
     * SUPPRESSION D'UN EMPLOYÉ
     * ===========================================
     * 
     * Cette méthode supprime définitivement un employé de la base de données.
     * Elle utilise la suppression en cascade pour gérer les relations
     * et inclut une gestion d'erreur robuste.
     * 
     * @param Employer $employer Employé à supprimer
     * @return \Illuminate\Http\RedirectResponse Redirection avec message de succès/erreur
     */
    public function delete(Employer $employer)
    {
        try {
            // Suppression de l'employé
            // Laravel gère automatiquement la suppression en cascade
            // si des relations sont définies dans le modèle
            $employer->delete();
            
            // Redirection avec message de succès
            return redirect()->route('employers.index')
                ->with('success', 'Employé supprimé avec succès.');
        } catch (Exception $e) {
            // Gestion des exceptions avec message d'erreur détaillé
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la suppression: ' . $e->getMessage());
        }
    }
}


