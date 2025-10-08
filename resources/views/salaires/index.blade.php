@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Salaires</h1>
            <p class="text-gray-600 mt-2">Gérez les salaires et générez les bulletins de paie</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('salaires.bulk') }}" class="btn-primary">
                <i class="fas fa-file-export mr-2"></i>
                Générer Tous les Bulletins
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Salaires</p>
                    <p class="stat-number">{{ number_format($totalSalaires, 2) }} XOF</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Moyenne</p>
                    <p class="stat-number">{{ number_format($moyenneSalaire, 2) }} XOF</p>
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
                    <p class="stat-number">{{ number_format($salaireMin, 2) }} XOF</p>
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
                    <p class="stat-number">{{ number_format($salaireMax, 2) }} XOF</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Salaires par département -->
    <div class="glass-card p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Salaires par Département</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($salairesParDepartement as $item)
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">{{ $item['departement']->name }}</h3>
                    <span class="text-sm text-gray-500">{{ $item['employes_count'] }} employés</span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Total:</span>
                        <span class="font-medium">{{ number_format($item['total'], 2) }} XOF</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Moyenne:</span>
                        <span class="font-medium">{{ number_format($item['moyenne'], 2) }} XOF</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Liste des employés avec salaires -->
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Liste des Employés</h2>
            <div class="flex space-x-2">
                <input type="text" placeholder="Rechercher un employé..." class="input-modern w-64">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Employé</th>
                        <th>Département</th>
                        <th>Salaire Journalier</th>
                        <th>Salaire Mensuel</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employers as $employer)
                    <tr>
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
                        <td>
                            <div class="flex space-x-2">
                                <a href="{{ route('salaires.payslip', $employer->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-file-pdf mr-1"></i>
                                    Bulletin
                                </a>
                                <a href="{{ route('employers.edit', $employer->id) }}" 
                                   class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                                    <i class="fas fa-edit mr-1"></i>
                                    Modifier
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
