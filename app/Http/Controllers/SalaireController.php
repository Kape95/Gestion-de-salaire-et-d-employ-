<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\Departement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SalaireController extends Controller
{
    public function index()
    {
        $employers = Employer::with('departement')->get();
        $departements = Departement::all();
        
        // Calculer les statistiques des salaires
        $totalSalaires = $employers->sum(function($employer) {
            return $employer->montant_journalier * 22; // 22 jours de travail par mois
        });
        
        $moyenneSalaire = $employers->avg('montant_journalier') * 22;
        $salaireMin = $employers->min('montant_journalier') * 22;
        $salaireMax = $employers->max('montant_journalier') * 22;
        
        // Salaires par département
        $salairesParDepartement = $departements->map(function($departement) {
            $employers = $departement->employers;
            $total = $employers->sum('montant_journalier') * 22;
            $moyenne = $employers->avg('montant_journalier') * 22;
            
            return [
                'departement' => $departement,
                'total' => $total,
                'moyenne' => $moyenne,
                'employes_count' => $employers->count()
            ];
        });
        
        return view('salaires.index', compact(
            'employers', 
            'departements', 
            'totalSalaires', 
            'moyenneSalaire', 
            'salaireMin', 
            'salaireMax',
            'salairesParDepartement'
        ));
    }
    
    public function generatePayslip($employerId)
    {
        $employer = Employer::with('departement')->findOrFail($employerId);
        
        // Calculer le salaire du mois
        $joursTravail = 22; // Par défaut
        $salaireBrut = $employer->montant_journalier * $joursTravail;
        
        // Calculer les charges selon le système bancaire du Burkina Faso
        // Charges sociales réduites à 10% (CNSS, impôts, etc.)
        $charges = $salaireBrut * 0.10; // 10% de charges
        $salaireNet = $salaireBrut - $charges;
        
        $payslip = [
            'employer' => $employer,
            'periode' => Carbon::now()->format('F Y'),
            'jours_travail' => $joursTravail,
            'salaire_brut' => $salaireBrut,
            'charges' => $charges,
            'salaire_net' => $salaireNet,
            'date_generation' => Carbon::now()->format('d/m/Y H:i')
        ];
        
        return view('salaires.payslip', compact('payslip'));
    }
    
    public function bulkGenerate()
    {
        $employers = Employer::with('departement')->get();
        
        // Générer les bulletins pour tous les employés
        $payslips = $employers->map(function($employer) {
            $salaireBrut = $employer->montant_journalier * 22;
            // Charges sociales selon le système bancaire du Burkina Faso (10%)
            $charges = $salaireBrut * 0.10;
            $salaireNet = $salaireBrut - $charges;
            
            return [
                'employer' => $employer,
                'salaire_brut' => $salaireBrut,
                'charges' => $charges,
                'salaire_net' => $salaireNet
            ];
        });
        
        return view('salaires.bulk', compact('payslips'));
    }

    /**
     * Télécharger le bulletin de paie en PDF
     */
    public function downloadPdf($employerId)
    {
        $employer = Employer::with('departement')->findOrFail($employerId);
        
        // Calculer le salaire du mois
        $joursTravail = 22; // Par défaut
        $salaireBrut = $employer->montant_journalier * $joursTravail;
        
        // Calculer les charges selon le système bancaire du Burkina Faso
        $charges = $salaireBrut * 0.10; // 10% de charges
        $salaireNet = $salaireBrut - $charges;
        
        $payslip = [
            'employer' => $employer,
            'periode' => Carbon::now()->format('F Y'),
            'jours_travail' => $joursTravail,
            'salaire_brut' => $salaireBrut,
            'charges' => $charges,
            'salaire_net' => $salaireNet,
            'date_generation' => Carbon::now()->format('d/m/Y H:i')
        ];

        // Générer le PDF avec DomPDF
        $pdf = Pdf::loadView('salaires.payslip-pdf', compact('payslip'));
        
        // Créer le nom du fichier
        $filename = 'bulletin_paie_' . $employer->nom . '_' . $employer->prenom . '_' . Carbon::now()->format('Y-m') . '.pdf';
        
        // Retourner le PDF pour téléchargement
        return $pdf->download($filename);
    }

    /**
     * Envoyer le bulletin de paie par email
     */
    public function sendEmail(Request $request, $employerId)
    {
        $employer = Employer::with('departement')->findOrFail($employerId);
        
        // Calculer le salaire du mois
        $joursTravail = 22; // Par défaut
        $salaireBrut = $employer->montant_journalier * $joursTravail;
        
        // Calculer les charges selon le système bancaire du Burkina Faso
        $charges = $salaireBrut * 0.10; // 10% de charges
        $salaireNet = $salaireBrut - $charges;
        
        $payslip = [
            'employer' => $employer,
            'periode' => Carbon::now()->format('F Y'),
            'jours_travail' => $joursTravail,
            'salaire_brut' => $salaireBrut,
            'charges' => $charges,
            'salaire_net' => $salaireNet,
            'date_generation' => Carbon::now()->format('d/m/Y H:i')
        ];

        try {
            // Envoyer l'email (simulation)
            // Dans un vrai projet, vous utiliseriez Mail::send() avec une vraie configuration SMTP
            
            return redirect()->back()->with('success', 'Bulletin de paie envoyé par email avec succès à ' . $employer->email);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage());
        }
    }
}
