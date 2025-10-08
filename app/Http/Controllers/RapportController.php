<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\Departement;
use Carbon\Carbon;

/**
 * ===========================================
 * CONTRÔLEUR DE GESTION DES RAPPORTS
 * ===========================================
 * 
 * Ce contrôleur gère tous les rapports et analyses de l'application.
 * Il fournit des statistiques détaillées sur les employés, départements et salaires.
 * 
 * Fonctionnalités :
 * - Tableau de bord avec métriques globales
 * - Rapports par département
 * - Analyses des salaires
 * - Statistiques en temps réel
 * 
 * @author [Votre Nom]
 * @version 1.0
 */
class RapportController extends Controller
{
    /**
     * ===========================================
     * TABLEAU DE BORD PRINCIPAL - RAPPORTS GLOBAUX
     * ===========================================
     * 
     * Cette méthode affiche le tableau de bord principal avec toutes les métriques
     * importantes de l'entreprise : nombre d'employés, départements, salaires totaux,
     * statistiques par département, et listes des employés.
     * 
     * @return \Illuminate\View\View Vue du tableau de bord
     */
    public function index()
    {
        // ===========================================
        // MÉTRIQUES GLOBALES DE L'ENTREPRISE
        // ===========================================
        
        // Nombre total d'employés dans l'entreprise
        $totalEmployers = Employer::count();
        
        // Nombre total de départements
        $totalDepartements = Departement::count();
        
        // Masse salariale totale (salaire journalier × 22 jours de travail)
        $totalSalaires = Employer::sum('montant_journalier') * 22;
        
        // ===========================================
        // STATISTIQUES DÉTAILLÉES PAR DÉPARTEMENT
        // ===========================================
        
        // Récupération de tous les départements avec le nombre d'employés
        $statsDepartements = Departement::withCount('employers')->get()->map(function($departement) use ($totalEmployers) {
            // Récupération des employés du département
            $employers = $departement->employers;
            
            // Calcul du salaire total du département (salaire journalier × 22 jours)
            $totalSalaire = $employers->sum('montant_journalier') * 22;
            
            // Calcul du salaire moyen du département
            $moyenneSalaire = $employers->avg('montant_journalier') * 22;
            
            // Retour des statistiques du département
            return [
                'departement' => $departement,
                'employes_count' => $departement->employers_count,
                'total_salaire' => $totalSalaire,
                'moyenne_salaire' => $moyenneSalaire,
                'pourcentage' => $totalEmployers > 0 ? round(($departement->employers_count / $totalEmployers) * 100, 1) : 0
            ];
        });
        
        // ===========================================
        // LISTES SPÉCIALISÉES D'EMPLOYÉS
        // ===========================================
        
        // Top 5 des employés les mieux payés (par salaire journalier)
        $topEmployers = Employer::with('departement')
            ->orderBy('montant_journalier', 'desc')
            ->take(5)
            ->get();
        
        // Employés récemment embauchés (5 derniers)
        $recentEmployers = Employer::with('departement')
            ->orderBy('date_embauche', 'desc')
            ->take(5)
            ->get();
        
        // ===========================================
        // RETOUR DE LA VUE AVEC TOUTES LES DONNÉES
        // ===========================================
        
        return view('rapports.index', compact(
            'totalEmployers',
            'totalDepartements', 
            'totalSalaires',
            'statsDepartements',
            'topEmployers',
            'recentEmployers'
        ));
    }
    
    public function departements()
    {
        $departements = Departement::with('employers')->get();
        
        $rapport = $departements->map(function($departement) {
            $employers = $departement->employers;
            $totalSalaire = $employers->sum('montant_journalier') * 22;
            $moyenneSalaire = $employers->avg('montant_journalier') * 22;
            $salaireMin = $employers->min('montant_journalier') * 22;
            $salaireMax = $employers->max('montant_journalier') * 22;
            
            return [
                'departement' => $departement,
                'employes_count' => $employers->count(),
                'total_salaire' => $totalSalaire,
                'moyenne_salaire' => $moyenneSalaire,
                'salaire_min' => $salaireMin,
                'salaire_max' => $salaireMax,
                'employes' => $employers
            ];
        });
        
        return view('rapports.departements', compact('rapport'));
    }
    
    public function salaires()
    {
        $employers = Employer::with('departement')->get();
        
        // Statistiques des salaires
        $stats = [
            'total' => $employers->sum('montant_journalier') * 22,
            'moyenne' => $employers->avg('montant_journalier') * 22,
            'minimum' => $employers->min('montant_journalier') * 22,
            'maximum' => $employers->max('montant_journalier') * 22,
            'ecart_type' => $this->calculateStandardDeviation($employers->pluck('montant_journalier')->toArray()) * 22
        ];
        
        // Répartition par tranches de salaires
        $tranches = [
            '0-2000' => $employers->filter(fn($e) => $e->montant_journalier * 22 <= 2000)->count(),
            '2001-3000' => $employers->filter(fn($e) => $e->montant_journalier * 22 > 2000 && $e->montant_journalier * 22 <= 3000)->count(),
            '3001-4000' => $employers->filter(fn($e) => $e->montant_journalier * 22 > 3000 && $e->montant_journalier * 22 <= 4000)->count(),
            '4001+' => $employers->filter(fn($e) => $e->montant_journalier * 22 > 4000)->count(),
        ];
        
        return view('rapports.salaires', compact('employers', 'stats', 'tranches'));
    }
    
    private function calculateStandardDeviation($array)
    {
        $mean = array_sum($array) / count($array);
        $variance = array_sum(array_map(function($x) use ($mean) {
            return pow($x - $mean, 2);
        }, $array)) / count($array);
        
        return sqrt($variance);
    }
}
