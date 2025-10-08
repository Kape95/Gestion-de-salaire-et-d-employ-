
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Vue d'ensemble de votre gestion des salaires</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="btn-outline">
                <i class="fas fa-download mr-2"></i>
                Exporter
            </button>
            <a href="{{ route('employers.create') }}" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Nouvel Employé
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Employés -->
        <div class="stat-card" x-data="{ count: 0, target: {{ $totalEmployers ?? 0 }} }" x-init="
            $nextTick(() => {
                const increment = target / 50;
                const timer = setInterval(() => {
                    count += increment;
                    if (count >= target) {
                        count = target;
                        clearInterval(timer);
                    }
                }, 20);
            })
        ">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Employés</p>
                    <p class="stat-number" x-text="Math.round(count)">{{ $totalEmployers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-600">+12%</span>
                <span class="text-gray-500 ml-1">ce mois</span>
            </div>
        </div>

        <!-- Total Départements -->
        <div class="stat-card" x-data="{ count: 0, target: {{ $totalDepartements ?? 0 }} }" x-init="
            $nextTick(() => {
                const increment = target / 30;
                const timer = setInterval(() => {
                    count += increment;
                    if (count >= target) {
                        count = target;
                        clearInterval(timer);
                    }
                }, 30);
            })
        ">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Départements</p>
                    <p class="stat-number" x-text="Math.round(count)">{{ $totalDepartements ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-600">+5%</span>
                <span class="text-gray-500 ml-1">ce mois</span>
            </div>
        </div>

        <!-- Masse Salariale -->
        <div class="stat-card" x-data="{ count: 0, target: {{ $totalAdministrateurs ?? 0 }} }" x-init="
            $nextTick(() => {
                const increment = target / 40;
                const timer = setInterval(() => {
                    count += increment;
                    if (count >= target) {
                        count = target;
                        clearInterval(timer);
                    }
                }, 25);
            })
        ">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Administrateurs</p>
                    <p class="stat-number" x-text="Math.round(count)">{{ $totalAdministrateurs ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-shield text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-600">+8%</span>
                <span class="text-gray-500 ml-1">ce mois</span>
            </div>
        </div>

        <!-- Paiements en Retard -->
        <div class="stat-card" x-data="{ count: 0, target: 0 }" x-init="
            $nextTick(() => {
                const increment = target / 20;
                const timer = setInterval(() => {
                    count += increment;
                    if (count >= target) {
                        count = target;
                        clearInterval(timer);
                    }
                }, 50);
            })
        ">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Paiements Retard</p>
                    <p class="stat-number" x-text="Math.round(count)">0</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-down text-green-500 mr-1"></i>
                <span class="text-green-600">-15%</span>
                <span class="text-gray-500 ml-1">ce mois</span>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Activité Récente</h3>
                <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Voir tout
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center p-3 bg-white/50 rounded-lg">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user-plus text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Nouvel employé ajouté</p>
                        <p class="text-xs text-gray-500">Kapé Le Code - Département IT</p>
                    </div>
                    <span class="text-xs text-gray-400">Il y a 2h</span>
                </div>
                
                <div class="flex items-center p-3 bg-white/50 rounded-lg">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-money-bill-wave text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Paiement effectué</p>
                        <p class="text-xs text-gray-500">Salaire de Bernard Coulibaly</p>
                    </div>
                    <span class="text-xs text-gray-400">Il y a 4h</span>
                </div>
                
                <div class="flex items-center p-3 bg-white/50 rounded-lg">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-building text-purple-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Département créé</p>
                        <p class="text-xs text-gray-500">Département Marketing</p>
                    </div>
                    <span class="text-xs text-gray-400">Il y a 6h</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Actions Rapides</h3>
            
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('employers.create') }}" class="p-4 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl text-white text-center hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-user-plus text-2xl mb-2"></i>
                    <p class="font-medium">Ajouter Employé</p>
                </a>
                
                <a href="{{ route('departements.create') }}" class="p-4 bg-gradient-to-r from-green-500 to-green-600 rounded-xl text-white text-center hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-building text-2xl mb-2"></i>
                    <p class="font-medium">Nouveau Département</p>
                </a>
                
                <a href="{{ route('salaires.bulk') }}" class="p-4 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl text-white text-center hover:from-purple-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-file-invoice-dollar text-2xl mb-2"></i>
                    <p class="font-medium">Générer Paie</p>
                </a>
                
                <a href="{{ route('rapports.index') }}" class="p-4 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl text-white text-center hover:from-orange-600 hover:to-orange-700 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-chart-bar text-2xl mb-2"></i>
                    <p class="font-medium">Voir Rapports</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Employees Table -->
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Employés Récents</h3>
            <a href="{{ route('employers.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                Voir tous les employés
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Employé</th>
                        <th>Département</th>
                        <th>Salaire Journalier</th>
                        <th>Date d'embauche</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEmployers ?? [] as $employer)
                    <tr>
                        <td>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-semibold">{{ substr($employer->nom, 0, 1) }}{{ substr($employer->prenom, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $employer->nom }} {{ $employer->prenom }}</p>
                                    <p class="text-sm text-gray-500">{{ $employer->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                {{ $employer->departement->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="font-medium">{{ number_format($employer->montant_journalier, 0, ',', ' ') }} FCFA</td>
                        <td>{{ $employer->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                Actif
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('employers.edit', $employer) }}" class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button 
                                    onclick="confirmDelete({{ $employer->id }})"
                                    class="text-red-600 hover:text-red-700"
                                    title="Supprimer"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-500">
                            <i class="fas fa-users text-4xl mb-4"></i>
                            <p>Aucun employé trouvé</p>
                            <a href="{{ route('employers.create') }}" class="btn-primary mt-4 inline-block">
                                Ajouter le premier employé
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    // Confirmation simple avec alert
    if (confirm('Êtes-vous sûr de vouloir supprimer cet employé ? Cette action est irréversible.')) {
        // Créer un formulaire temporaire et le soumettre
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/employers/delete/${id}`;
        
        // Ajouter le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        // Ajouter la méthode DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        // Ajouter le formulaire au DOM et le soumettre
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection