

@extends('layouts.app')

@section('title', 'Liste des Employés')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Employés</h1>
            <p class="text-gray-600 mt-1">Gérez vos employés et leurs informations</p>
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

    <!-- Search and Filters -->
    <div class="glass-card p-6" x-data="{ search: '', department: '', status: '' }">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input 
                    type="text" 
                    x-model="search"
                    placeholder="Rechercher un employé..." 
                    class="input-modern pl-10"
                >
            </div>

            <!-- Department Filter -->
            <select x-model="department" class="input-modern">
                <option value="">Tous les départements</option>
                @foreach($departements ?? [] as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>

            <!-- Status Filter -->
            <select x-model="status" class="input-modern">
                <option value="">Tous les statuts</option>
                <option value="actif">Actif</option>
                <option value="inactif">Inactif</option>
            </select>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Employés</p>
                    <p class="stat-number">{{ $stats['totalEmployers'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Employés Actifs</p>
                    <p class="stat-number">{{ $stats['activeEmployers'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-check text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Salaire Moyen</p>
                    <p class="stat-number">{{ number_format($stats['averageSalary'] ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Nouveaux ce mois</p>
                    <p class="stat-number">{{ $stats['newThisMonth'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-plus text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="glass-card p-6">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th class="cursor-pointer" @click="sort('name')">
                            <div class="flex items-center">
                                Employé
                                <i class="fas fa-sort ml-2"></i>
                            </div>
                        </th>
                        <th class="cursor-pointer" @click="sort('department')">
                            <div class="flex items-center">
                                Département
                                <i class="fas fa-sort ml-2"></i>
                            </div>
                        </th>
                        <th class="cursor-pointer" @click="sort('salary')">
                            <div class="flex items-center">
                                Salaire Journalier
                                <i class="fas fa-sort ml-2"></i>
                            </div>
                        </th>
                        <th class="cursor-pointer" @click="sort('contact')">
                            <div class="flex items-center">
                                Contact
                                <i class="fas fa-sort ml-2"></i>
                            </div>
                        </th>
                        <th class="cursor-pointer" @click="sort('created_at')">
                            <div class="flex items-center">
                                Date d'embauche
                                <i class="fas fa-sort ml-2"></i>
                            </div>
                        </th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employers as $employer)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-semibold text-sm">
                                        {{ substr($employer->nom, 0, 1) }}{{ substr($employer->prenom, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $employer->nom }} {{ $employer->prenom }}</p>
                                    <p class="text-sm text-gray-500">{{ $employer->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                {{ $employer->departement->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="font-semibold text-gray-900">
                            {{ number_format($employer->montant_journalier, 0, ',', ' ') }} FCFA
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-900">{{ $employer->contact }}</span>
                                <button 
                                    @click="utils.copyToClipboard('{{ $employer->contact }}')"
                                    class="text-gray-400 hover:text-gray-600"
                                    title="Copier le numéro"
                                >
                                    <i class="fas fa-copy text-xs"></i>
                                </button>
                            </div>
                        </td>
                        <td class="text-gray-600">
                            {{ $employer->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                Actif
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <a 
                                    href="{{ route('employers.edit', $employer) }}" 
                                    class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                                    title="Modifier"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button 
                                    onclick="confirmDelete({{ $employer->id }})"
                                    class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                    title="Supprimer"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                                <a 
                                    href="#" 
                                    class="text-green-600 hover:text-green-700 p-2 rounded-lg hover:bg-green-50 transition-colors"
                                    title="Voir détails"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-12">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun employé trouvé</h3>
                                <p class="text-gray-500 mb-4">Commencez par ajouter votre premier employé</p>
                                <a href="{{ route('employers.create') }}" class="btn-primary">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter un employé
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($employers->hasPages())
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Affichage de {{ $employers->firstItem() }} à {{ $employers->lastItem() }} 
                sur {{ $employers->total() }} employés
            </div>
            
            <div class="flex items-center space-x-2">
                @if($employers->onFirstPage())
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $employers->previousPageUrl() }}" class="px-3 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                @foreach($employers->getUrlRange(1, $employers->lastPage()) as $page => $url)
                    @if($page == $employers->currentPage())
                        <span class="px-3 py-2 bg-primary-600 text-white rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                @if($employers->hasMorePages())
                    <a href="{{ $employers->nextPageUrl() }}" class="px-3 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
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