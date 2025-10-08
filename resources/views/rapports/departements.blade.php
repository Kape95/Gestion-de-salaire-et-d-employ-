@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Rapport par Départements</h1>
            <p class="text-gray-600 mt-2">Analyse détaillée de chaque département</p>
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
                    <i class="fas fa-building text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Départements</p>
                    <p class="stat-number">{{ count($rapport) }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Employés</p>
                    <p class="stat-number">{{ $rapport->sum('employes_count') }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Masse Salariale</p>
                    <p class="stat-number">{{ number_format($rapport->sum('total_salaire'), 0) }} XOF</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Moyenne/Employé</p>
                    <p class="stat-number">{{ $rapport->sum('employes_count') > 0 ? number_format($rapport->sum('total_salaire') / $rapport->sum('employes_count'), 0) : 0 }} XOF</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Rapport détaillé par département -->
    <div class="space-y-6">
        @foreach($rapport as $item)
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4" style="background-color: {{ $item['departement']->couleur ?? '#3B82F6' }}">
                        <i class="fas fa-building text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $item['departement']->name }}</h3>
                        <p class="text-gray-600">{{ $item['departement']->description ?? 'Aucune description' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $item['departement']->status === 'actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $item['departement']->status === 'actif' ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>

            <!-- Statistiques du département -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                    <p class="text-sm text-gray-600">Employés</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $item['employes_count'] }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                    <p class="text-sm text-gray-600">Total Salaire</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($item['total_salaire'], 0) }} XOF</p>
                </div>
                <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                    <p class="text-sm text-gray-600">Salaire Moyen</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($item['moyenne_salaire'], 0) }} XOF</p>
                </div>
                <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                    <p class="text-sm text-gray-600">Écart Salarial</p>
                    <p class="text-2xl font-bold text-orange-600">{{ number_format($item['salaire_max'] - $item['salaire_min'], 0) }} XOF</p>
                </div>
            </div>

            <!-- Détails des salaires -->
            <div class="bg-white rounded-lg p-4 border border-gray-200 mb-6">
                <h4 class="font-semibold text-gray-900 mb-3">Répartition des Salaires</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Salaire Minimum</p>
                        <p class="text-lg font-semibold text-red-600">{{ number_format($item['salaire_min'], 2) }} XOF</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Salaire Maximum</p>
                        <p class="text-lg font-semibold text-green-600">{{ number_format($item['salaire_max'], 2) }} XOF</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Salaire Moyen</p>
                        <p class="text-lg font-semibold text-blue-600">{{ number_format($item['moyenne_salaire'], 2) }} XOF</p>
                    </div>
                </div>
            </div>

            <!-- Liste des employés -->
            @if($item['employes']->count() > 0)
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-200">
                    <h4 class="font-semibold text-gray-900">Employés du Département</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employé</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poste</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salaire Journalier</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salaire Mensuel</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'embauche</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($item['employes'] as $employer)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white font-semibold text-xs">
                                                {{ strtoupper(substr($employer->prenom, 0, 1) . substr($employer->nom, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $employer->prenom }} {{ $employer->nom }}</p>
                                            <p class="text-sm text-gray-500">{{ $employer->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $employer->poste }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ number_format($employer->montant_journalier, 2) }} XOF</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ number_format($employer->montant_journalier * 22, 2) }} XOF</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ \Carbon\Carbon::parse($employer->date_embauche)->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="bg-gray-50 rounded-lg p-6 text-center">
                <i class="fas fa-users text-gray-400 text-3xl mb-3"></i>
                <p class="text-gray-600">Aucun employé dans ce département</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Résumé comparatif -->
    <div class="glass-card p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Comparaison des Départements</h3>
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Département</th>
                        <th>Employés</th>
                        <th>Total Salaire</th>
                        <th>Salaire Moyen</th>
                        <th>Salaire Min</th>
                        <th>Salaire Max</th>
                        <th>Écart</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rapport as $item)
                    <tr>
                        <td>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $item['departement']->couleur ?? '#3B82F6' }}"></div>
                                <span class="font-medium text-gray-900">{{ $item['departement']->name }}</span>
                            </div>
                        </td>
                        <td class="text-center font-medium">{{ $item['employes_count'] }}</td>
                        <td class="text-center font-medium">{{ number_format($item['total_salaire'], 0) }} XOF</td>
                        <td class="text-center font-medium">{{ number_format($item['moyenne_salaire'], 0) }} XOF</td>
                        <td class="text-center font-medium text-red-600">{{ number_format($item['salaire_min'], 0) }} XOF</td>
                        <td class="text-center font-medium text-green-600">{{ number_format($item['salaire_max'], 0) }} XOF</td>
                        <td class="text-center font-medium text-orange-600">{{ number_format($item['salaire_max'] - $item['salaire_min'], 0) }} XOF</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
