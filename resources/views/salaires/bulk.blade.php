@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Génération des Bulletins de Paie</h1>
            <p class="text-gray-600 mt-2">Générez les bulletins de paie pour tous les employés</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('salaires.index') }}" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux Salaires
            </a>
            <button class="btn-primary" onclick="window.print()">
                <i class="fas fa-print mr-2"></i>
                Imprimer Tous
            </button>
        </div>
    </div>

    <!-- Informations de la période -->
    <div class="glass-card p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center">
                <p class="text-sm text-gray-600">Période</p>
                <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::now()->format('F Y') }}</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600">Employés</p>
                <p class="text-lg font-semibold text-gray-900">{{ count($payslips) }}</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600">Total Brut</p>
                <p class="text-lg font-semibold text-gray-900">{{ number_format($payslips->sum('salaire_brut'), 2) }} XOF</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600">Total Net</p>
                <p class="text-lg font-semibold text-gray-900">{{ number_format($payslips->sum('salaire_net'), 2) }} XOF</p>
            </div>
        </div>
    </div>

    <!-- Liste des bulletins -->
    <div class="space-y-6">
        @foreach($payslips as $payslip)
        <div class="glass-card p-6 print:break-inside-avoid">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-semibold text-sm">
                            {{ strtoupper(substr($payslip['employer']->prenom, 0, 1) . substr($payslip['employer']->nom, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $payslip['employer']->prenom }} {{ $payslip['employer']->nom }}</h3>
                        <p class="text-gray-600">{{ $payslip['employer']->poste }} - {{ $payslip['employer']->departement->name ?? 'Non assigné' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Bulletin de Paie</p>
                    <p class="text-lg font-bold text-blue-600">{{ number_format($payslip['salaire_net'], 2) }} XOF</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Informations employé -->
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <h4 class="font-semibold text-gray-900 mb-3">Informations Employé</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Matricule:</span>
                            <span class="text-sm font-medium">{{ $payslip['employer']->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Département:</span>
                            <span class="text-sm font-medium">{{ $payslip['employer']->departement->name ?? 'Non assigné' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Poste:</span>
                            <span class="text-sm font-medium">{{ $payslip['employer']->poste }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Date d'embauche:</span>
                            <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($payslip['employer']->date_embauche)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Détails du salaire -->
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <h4 class="font-semibold text-gray-900 mb-3">Détails du Salaire</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Jours travaillés:</span>
                            <span class="text-sm font-medium">22</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Salaire journalier:</span>
                            <span class="text-sm font-medium">{{ number_format($payslip['employer']->montant_journalier, 2) }} XOF</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Salaire brut:</span>
                            <span class="text-sm font-medium">{{ number_format($payslip['salaire_brut'], 2) }} XOF</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Charges (CNSS, Impôts) - 10%:</span>
                            <span class="text-sm font-medium text-red-600">-{{ number_format($payslip['charges'], 2) }} XOF</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between">
                            <span class="text-sm font-semibold text-gray-900">Salaire net:</span>
                            <span class="text-sm font-bold text-green-600">{{ number_format($payslip['salaire_net'], 2) }} XOF</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <h4 class="font-semibold text-gray-900 mb-3">Actions</h4>
                    <div class="space-y-2">
                        <a href="{{ route('salaires.payslip', $payslip['employer']->id) }}" 
                           class="w-full btn-primary text-center text-sm">
                            <i class="fas fa-eye mr-2"></i>
                            Voir Détails
                        </a>
                        <button onclick="window.print()" class="w-full btn-outline text-center text-sm">
                            <i class="fas fa-print mr-2"></i>
                            Imprimer
                        </button>
                        <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg text-sm transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            Télécharger PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Résumé final -->
    <div class="glass-card p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Résumé de la Paie</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-gray-600">Total Salaire Brut</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($payslips->sum('salaire_brut'), 2) }} XOF</p>
            </div>
            <div class="text-center p-4 bg-red-50 rounded-lg">
                <p class="text-sm text-gray-600">Total Charges</p>
                <p class="text-2xl font-bold text-red-600">{{ number_format($payslips->sum('charges'), 2) }} XOF</p>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <p class="text-sm text-gray-600">Total Salaire Net</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($payslips->sum('salaire_net'), 2) }} XOF</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <p class="text-sm text-gray-600">Nombre d'Employés</p>
                <p class="text-2xl font-bold text-purple-600">{{ count($payslips) }}</p>
            </div>
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
    
    .print\\:break-inside-avoid {
        break-inside: avoid;
    }
}
</style>
@endsection
