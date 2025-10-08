@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Rapports et Analyses</h1>
            <p class="text-gray-600 mt-2">Analysez les données de votre entreprise</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('rapports.departements') }}" class="btn-primary">
                <i class="fas fa-building mr-2"></i>
                Rapport Départements
            </a>
            <a href="{{ route('rapports.salaires') }}" class="btn-primary">
                <i class="fas fa-chart-bar mr-2"></i>
                Rapport Salaires
            </a>
        </div>
    </div>

    <!-- Statistiques générales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Employés</p>
                    <p class="stat-number">{{ $totalEmployers }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-building text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Départements</p>
                    <p class="stat-number">{{ $totalDepartements }}</p>
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
                    <p class="stat-number">{{ number_format($totalSalaires, 0) }} XOF</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-chart-pie text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Moyenne/Employé</p>
                    <p class="stat-number">{{ $totalEmployers > 0 ? number_format($totalSalaires / $totalEmployers, 0) : 0 }} XOF</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Répartition par département -->
    <div class="glass-card p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Répartition par Département</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($statsDepartements as $stat)
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">{{ $stat['departement']->name }}</h3>
                    <span class="text-sm text-gray-500">{{ $stat['pourcentage'] }}%</span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Employés:</span>
                        <span class="font-medium">{{ $stat['employes_count'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Total Salaire:</span>
                        <span class="font-medium">{{ number_format($stat['total_salaire'], 0) }} XOF</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Moyenne:</span>
                        <span class="font-medium">{{ number_format($stat['moyenne_salaire'], 0) }} XOF</span>
                    </div>
                </div>
                <!-- Barre de progression -->
                <div class="mt-3">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $stat['pourcentage'] }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Top 5 des employés les mieux payés -->
    <div class="glass-card p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Top 5 des Employés les Mieux Payés</h2>
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Employé</th>
                        <th>Département</th>
                        <th>Salaire Journalier</th>
                        <th>Salaire Mensuel</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topEmployers as $index => $employer)
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
                                    <p class="text-sm text-gray-500">{{ $employer->poste }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $employer->departement->name ?? 'Non assigné' }}
                            </span>
                        </td>
                        <td class="font-medium">{{ number_format($employer->montant_journalier, 2) }} XOF</td>
                        <td class="font-medium">{{ number_format($employer->montant_journalier * 22, 2) }} XOF</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Employés récemment embauchés -->
    <div class="glass-card p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Employés Récemment Embauchés</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($recentEmployers as $employer)
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                        <span class="text-white font-semibold text-sm">
                            {{ strtoupper(substr($employer->prenom, 0, 1) . substr($employer->nom, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $employer->prenom }} {{ $employer->nom }}</h3>
                        <p class="text-sm text-gray-500">{{ $employer->poste }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Département:</span>
                        <span class="text-sm font-medium">{{ $employer->departement->name ?? 'Non assigné' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Date d'embauche:</span>
                        <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($employer->date_embauche)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Salaire:</span>
                        <span class="text-sm font-medium">{{ number_format($employer->montant_journalier * 22, 0) }} XOF</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
