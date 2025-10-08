@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Bulletin de Paie</h1>
            <p class="text-gray-600 mt-2">{{ $payslip['employer']->prenom }} {{ $payslip['employer']->nom }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('salaires.index') }}" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux Salaires
            </a>
            <button class="btn-primary" onclick="window.print()">
                <i class="fas fa-print mr-2"></i>
                Imprimer
            </button>
        </div>
    </div>

    <!-- Bulletin de paie -->
    <div class="glass-card p-8 print:bg-white">
        <!-- En-tête du bulletin -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">BULLETIN DE PAIE</h2>
            <p class="text-gray-600">Période : {{ $payslip['periode'] }}</p>
            <p class="text-gray-600">Généré le : {{ $payslip['date_generation'] }}</p>
        </div>

        <!-- Informations employé -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations Employé</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nom et Prénom:</span>
                        <span class="font-medium">{{ $payslip['employer']->prenom }} {{ $payslip['employer']->nom }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Matricule:</span>
                        <span class="font-medium">{{ $payslip['employer']->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Département:</span>
                        <span class="font-medium">{{ $payslip['employer']->departement->name ?? 'Non assigné' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Poste:</span>
                        <span class="font-medium">{{ $payslip['employer']->poste }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date d'embauche:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($payslip['employer']->date_embauche)->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de Paie</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Période:</span>
                        <span class="font-medium">{{ $payslip['periode'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jours travaillés:</span>
                        <span class="font-medium">{{ $payslip['jours_travail'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Salaire journalier:</span>
                        <span class="font-medium">{{ number_format($payslip['employer']->montant_journalier, 2) }} XOF</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Salaire brut:</span>
                        <span class="font-medium">{{ number_format($payslip['salaire_brut'], 2) }} XOF</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détail du salaire -->
        <div class="bg-white rounded-lg p-6 border border-gray-200 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Détail du Salaire</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-gray-900">Description</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-900">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-4 text-gray-600">Salaire de base ({{ $payslip['jours_travail'] }} jours)</td>
                            <td class="py-3 px-4 text-right font-medium">{{ number_format($payslip['salaire_brut'], 2) }} XOF</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-4 text-gray-600">Charges sociales (CNSS, Impôts) - 10%</td>
                            <td class="py-3 px-4 text-right font-medium text-red-600">-{{ number_format($payslip['charges'], 2) }} XOF</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="py-3 px-4 font-semibold text-gray-900">SALAIRE NET À PAYER</td>
                            <td class="py-3 px-4 text-right font-bold text-green-600 text-lg">{{ number_format($payslip['salaire_net'], 2) }} XOF</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Signature -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="text-center">
                <div class="border-t-2 border-gray-300 pt-4 mt-8">
                    <p class="text-sm text-gray-600">Signature de l'employé</p>
                </div>
            </div>
            <div class="text-center">
                <div class="border-t-2 border-gray-300 pt-4 mt-8">
                    <p class="text-sm text-gray-600">Signature de l'employeur</p>
                </div>
            </div>
        </div>

        <!-- Informations légales -->
        <div class="mt-8 p-4 bg-gray-50 rounded-lg">
            <p class="text-xs text-gray-600 text-center">
                Ce bulletin de paie est généré automatiquement par le système de gestion des salaires.<br>
                Pour toute question, veuillez contacter le service des ressources humaines.
            </p>
        </div>
    </div>

    <!-- Actions supplémentaires -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="flex flex-wrap gap-3">
            <button onclick="window.print()" class="btn-primary">
                <i class="fas fa-print mr-2"></i>
                Imprimer le Bulletin
            </button>
            <a href="{{ route('salaires.download-pdf', $payslip['employer']->id) }}" class="btn-outline">
                <i class="fas fa-download mr-2"></i>
                Télécharger PDF
            </a>
            <form method="POST" action="{{ route('salaires.send-email', $payslip['employer']->id) }}" class="inline">
                @csrf
                <button type="submit" class="btn-outline">
                    <i class="fas fa-envelope mr-2"></i>
                    Envoyer par Email
                </button>
            </form>
            <a href="{{ route('salaires.index') }}" class="btn-outline">
                <i class="fas fa-list mr-2"></i>
                Voir Tous les Salaires
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    .glass-card {
        background: white !important;
        box-shadow: none !important;
        border: 1px solid #e5e7eb !important;
    }
    
    .btn-primary, .btn-outline {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
}
</style>
@endsection
