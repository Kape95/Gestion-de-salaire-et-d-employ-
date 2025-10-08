@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Rapport des Salaires</h1>
            <p class="text-gray-600 mt-2">Analyse détaillée de la structure salariale</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('rapports.index') }}" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux Rapports
            </a>
            <button class="btn-primary" onclick="window.print()">
                <i class="fas fa-print mr-2"></i>
                Imprimer le Rapport
            </button>
        </div>
    </div>

    <!-- Statistiques globales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Salaires</p>
                    <p class="stat-number">{{ number_format($stats['total'], 0) }} XOF</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Salaire Moyen</p>
                    <p class="stat-number">{{ number_format($stats['moyenne'], 0) }} XOF</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-arrow-down text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Salaire Min</p>
                    <p class="stat-number">{{ number_format($stats['minimum'], 0) }} XOF</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-arrow-up text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Salaire Max</p>
                    <p class="stat-number">{{ number_format($stats['maximum'], 0) }} XOF</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Analyse détaillée -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Répartition par tranches -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par Tranches de Salaires</h3>
            <div class="space-y-4">
                @foreach($tranches as $tranche => $count)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full mr-3 
                            @if($tranche === '0-2000') bg-red-500
                            @elseif($tranche === '2001-3000') bg-yellow-500
                            @elseif($tranche === '3001-4000') bg-blue-500
                            @else bg-green-500
                            @endif"></div>
                        <span class="text-sm font-medium text-gray-900">{{ $tranche }} XOF</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="h-2 rounded-full 
                                @if($tranche === '0-2000') bg-red-500
                                @elseif($tranche === '2001-3000') bg-yellow-500
                                @elseif($tranche === '3001-4000') bg-blue-500
                                @else bg-green-500
                                @endif"
                                 style="width: {{ $count > 0 ? ($count / $employers->count()) * 100 : 0 }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $count }} employés</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Statistiques avancées -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques Avancées</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                    <span class="text-sm text-gray-600">Écart-type</span>
                    <span class="font-semibold text-gray-900">{{ number_format($stats['ecart_type'], 0) }} XOF</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                    <span class="text-sm text-gray-600">Médiane</span>
                    <span class="font-semibold text-gray-900">{{ number_format($employers->median('montant_journalier') * 22, 0) }} XOF</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                    <span class="text-sm text-gray-600">Écart salarial</span>
                    <span class="font-semibold text-gray-900">{{ number_format($stats['maximum'] - $stats['minimum'], 0) }} XOF</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                    <span class="text-sm text-gray-600">Coefficient de variation</span>
                    <span class="font-semibold text-gray-900">{{ $stats['moyenne'] > 0 ? number_format(($stats['ecart_type'] / $stats['moyenne']) * 100, 1) : 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 10 des salaires -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top 10 des Salaires les Plus Élevés</h3>
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Employé</th>
                        <th>Département</th>
                        <th>Poste</th>
                        <th>Salaire Journalier</th>
                        <th>Salaire Mensuel</th>
                        <th>% du Max</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employers->sortByDesc('montant_journalier')->take(10) as $index => $employer)
                    <tr>
                        <td>
                            <div class="flex items-center">
                                @if($index == 0)
                                    <span class="w-8 h-8 bg-yellow-100 text-yellow-800 rounded-full flex items-center justify-center text-sm font-bold">🥇</span>
                                @elseif($index == 1)
                                    <span class="w-8 h-8 bg-gray-100 text-gray-800 rounded-full flex items-center justify-center text-sm font-bold">🥈</span>
                                @elseif($index == 2)
                                    <span class="w-8 h-8 bg-orange-100 text-orange-800 rounded-full flex items-center justify-center text-sm font-bold">🥉</span>
                                @else
                                    <span class="w-8 h-8 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-bold">{{ $index + 1 }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-semibold text-sm">
                                        {{ strtoupper(substr($employer->prenom, 0, 1) . substr($employer->nom, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $employer->prenom }} {{ $employer->nom }}</p>
                                    <p class="text-sm text-gray-500">{{ $employer->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $employer->departement->name ?? 'Non assigné' }}
                            </span>
                        </td>
                        <td class="text-sm text-gray-900">{{ $employer->poste }}</td>
                        <td class="font-medium">{{ number_format($employer->montant_journalier, 2) }} XOF</td>
                        <td class="font-medium">{{ number_format($employer->montant_journalier * 22, 2) }} XOF</td>
                        <td class="font-medium text-green-600">{{ number_format(($employer->montant_journalier * 22 / $stats['maximum']) * 100, 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Analyse par département -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Analyse Salariale par Département</h3>
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Département</th>
                        <th>Employés</th>
                        <th>Salaire Moyen</th>
                        <th>Salaire Min</th>
                        <th>Salaire Max</th>
                        <th>Écart</th>
                        <th>% de la Moyenne Globale</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employers->groupBy('departement_id') as $departementId => $employersDept)
                    @php
                        $departement = \App\Models\Departement::find($departementId);
                        $moyenneDept = $employersDept->avg('montant_journalier') * 22;
                        $minDept = $employersDept->min('montant_journalier') * 22;
                        $maxDept = $employersDept->max('montant_journalier') * 22;
                    @endphp
                    <tr>
                        <td>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $departement->couleur ?? '#3B82F6' }}"></div>
                                <span class="font-medium text-gray-900">{{ $departement->name ?? 'Non assigné' }}</span>
                            </div>
                        </td>
                        <td class="text-center font-medium">{{ $employersDept->count() }}</td>
                        <td class="text-center font-medium">{{ number_format($moyenneDept, 0) }} XOF</td>
                        <td class="text-center font-medium text-red-600">{{ number_format($minDept, 0) }} XOF</td>
                        <td class="text-center font-medium text-green-600">{{ number_format($maxDept, 0) }} XOF</td>
                        <td class="text-center font-medium text-orange-600">{{ number_format($maxDept - $minDept, 0) }} XOF</td>
                        <td class="text-center font-medium {{ $moyenneDept > $stats['moyenne'] ? 'text-green-600' : 'text-red-600' }}">
                            {{ $stats['moyenne'] > 0 ? number_format(($moyenneDept / $stats['moyenne']) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Graphique de distribution -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribution des Salaires</h3>
        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">Répartition par Quartiles</h4>
                    <div class="space-y-3">
                        @php
                            $sortedSalaries = $employers->pluck('montant_journalier')->sort()->values();
                            $count = $sortedSalaries->count();
                            $q1 = $count > 0 ? $sortedSalaries[floor($count * 0.25)] * 22 : 0;
                            $q2 = $count > 0 ? $sortedSalaries[floor($count * 0.5)] * 22 : 0;
                            $q3 = $count > 0 ? $sortedSalaries[floor($count * 0.75)] * 22 : 0;
                        @endphp
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Q1 (25%)</span>
                            <span class="font-medium">{{ number_format($q1, 0) }} XOF</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Q2 (Médiane - 50%)</span>
                            <span class="font-medium">{{ number_format($q2, 0) }} XOF</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Q3 (75%)</span>
                            <span class="font-medium">{{ number_format($q3, 0) }} XOF</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">Indicateurs de Dispersion</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Écart interquartile</span>
                            <span class="font-medium">{{ number_format($q3 - $q1, 0) }} XOF</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Asymétrie</span>
                            <span class="font-medium">{{ $stats['moyenne'] > $q2 ? 'Droite' : 'Gauche' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Concentration</span>
                            <span class="font-medium">{{ $stats['ecart_type'] < $stats['moyenne'] * 0.3 ? 'Élevée' : 'Faible' }}</span>
                        </div>
                    </div>
                </div>
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
}
</style>
@endsection
