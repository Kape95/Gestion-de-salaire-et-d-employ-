

@extends('layouts.app')

@section('title', 'Départements')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Départements</h1>
            <p class="text-gray-600 mt-1">Gérez les départements de votre organisation</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="btn-outline">
                <i class="fas fa-download mr-2"></i>
                Exporter
            </button>
            <a href="{{ route('departements.create') }}" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Nouveau Département
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Départements</p>
                    <p class="stat-number">{{ $departements->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Employés Total</p>
                    <p class="stat-number">{{ $totalEmployers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Masse Salariale</p>
                    <p class="stat-number">{{ number_format($totalSalary ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Départements Actifs</p>
                    <p class="stat-number">{{ $departements->where('status', 'actif')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Departments Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($departements as $departement)
        <div class="glass-card p-6 hover:transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-primary-400 to-primary-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-building text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $departement->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $departement->employers_count ?? 0 }} employés</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a 
                        href="{{ route('departements.edit', $departement) }}" 
                        class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                        title="Modifier"
                    >
                        <i class="fas fa-edit"></i>
                    </a>
                    <button 
                        @click="deleteDepartment({{ $departement->id }})"
                        class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors"
                        title="Supprimer"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Budget mensuel:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($departement->budget_mensuel ?? 0, 0, ',', ' ') }} FCFA</span>
                </div>
                
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Salaire moyen:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($departement->employers->avg('montant_journalier') ?? 0, 0, ',', ' ') }} FCFA</span>
                </div>
                
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Statut:</span>
                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                        Actif
                    </span>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Créé le {{ $departement->created_at->format('d/m/Y') }}</span>
                    <a 
                        href="#" 
                        class="text-primary-600 hover:text-primary-700 text-sm font-medium"
                    >
                        Voir détails
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="md:col-span-2 lg:col-span-3">
            <div class="glass-card p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-building text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun département trouvé</h3>
                <p class="text-gray-500 mb-6">Commencez par créer votre premier département</p>
                <a href="{{ route('departements.create') }}" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Créer un département
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($departements->hasPages())
    <div class="flex items-center justify-center">
        <div class="flex items-center space-x-2">
            @if($departements->onFirstPage())
                <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $departements->previousPageUrl() }}" class="px-3 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            @foreach($departements->getUrlRange(1, $departements->lastPage()) as $page => $url)
                @if($page == $departements->currentPage())
                    <span class="px-3 py-2 bg-primary-600 text-white rounded-lg">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">{{ $page }}</a>
                @endif
            @endforeach

            @if($departements->hasMorePages())
                <a href="{{ $departements->nextPageUrl() }}" class="px-3 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div x-data="{ showDeleteModal: false, departmentId: null }" x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        
        <div class="relative bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Confirmer la suppression</h3>
            </div>
            
            <p class="text-gray-600 mb-6">
                Êtes-vous sûr de vouloir supprimer ce département ? Cette action est irréversible.
            </p>
            
            <div class="flex items-center justify-end space-x-3">
                <button 
                    @click="showDeleteModal = false"
                    class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                >
                    Annuler
                </button>
                <form :action="`/departements/${departmentId}`" method="GET" class="inline">
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                    >
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteDepartment(id) {
    Alpine.store('showDeleteModal', true);
    Alpine.store('departmentId', id);
}
</script>
@endsection 