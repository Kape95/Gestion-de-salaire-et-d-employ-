

@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier le Département</h1>
            <p class="text-gray-600 mt-2">Modifiez les informations du département "{{ $departement->name }}"</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('departements.index') }}" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux Départements
            </a>
        </div>
    </div>

    <!-- Informations actuelles -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations Actuelles</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <div class="flex items-center mb-2">
                    <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $departement->couleur ?? '#3B82F6' }}"></div>
                    <span class="font-medium text-gray-900">{{ $departement->name }}</span>
                </div>
                <p class="text-sm text-gray-600">{{ $departement->description ?? 'Aucune description' }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <p class="text-sm text-gray-600">Statut</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $departement->status === 'actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $departement->status === 'actif' ? 'Actif' : 'Inactif' }}
                </span>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <p class="text-sm text-gray-600">Employés</p>
                <p class="text-lg font-semibold text-gray-900">{{ $departement->employers->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Formulaire de modification -->
    <div class="glass-card p-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Modifier les Informations</h2>
                <p class="text-gray-600">Modifiez les informations ci-dessous pour mettre à jour le département</p>
            </div>

            <form method="POST" action="{{ route('departements.update', $departement->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Nom du département -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du Département <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $departement->name) }}"
                           class="input-modern w-full @error('name') border-red-500 @enderror"
                           placeholder="Ex: Ressources Humaines, Informatique, Marketing..."
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="input-modern w-full @error('description') border-red-500 @enderror"
                              placeholder="Décrivez les responsabilités et objectifs de ce département...">{{ old('description', $departement->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget mensuel -->
                <div>
                    <label for="budget_mensuel" class="block text-sm font-medium text-gray-700 mb-2">
                        Budget Mensuel (XOF)
                    </label>
                    <input type="number" 
                           id="budget_mensuel" 
                           name="budget_mensuel" 
                           value="{{ old('budget_mensuel', $departement->budget_mensuel) }}"
                           step="0.01"
                           class="input-modern w-full @error('budget_mensuel') border-red-500 @enderror"
                           placeholder="0.00">
                    @error('budget_mensuel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut
                    </label>
                    <select id="status" 
                            name="status" 
                            class="input-modern w-full @error('status') border-red-500 @enderror">
                        <option value="actif" {{ old('status', $departement->status) == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ old('status', $departement->status) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Couleur -->
                <div>
                    <label for="couleur" class="block text-sm font-medium text-gray-700 mb-2">
                        Couleur du Département
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="color" 
                               id="couleur" 
                               name="couleur" 
                               value="{{ old('couleur', $departement->couleur ?? '#3B82F6') }}"
                               class="w-16 h-12 rounded-lg border-2 border-gray-300 cursor-pointer">
                        <span class="text-sm text-gray-600">Choisissez une couleur pour identifier ce département</span>
                    </div>
                    @error('couleur')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Responsable -->
                <div>
                    <label for="responsable_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Responsable du Département
                    </label>
                    <select id="responsable_id" 
                            name="responsable_id" 
                            class="input-modern w-full @error('responsable_id') border-red-500 @enderror">
                        <option value="">Sélectionner un responsable</option>
                        @foreach(\App\Models\Employer::all() as $employer)
                            <option value="{{ $employer->id }}" {{ old('responsable_id', $departement->responsable_id) == $employer->id ? 'selected' : '' }}>
                                {{ $employer->prenom }} {{ $employer->nom }} - {{ $employer->poste }}
                            </option>
                        @endforeach
                    </select>
                    @error('responsable_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex space-x-3">
                        <a href="{{ route('departements.index') }}" class="btn-outline">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                        <button type="button" 
                                onclick="if(confirm('Êtes-vous sûr de vouloir supprimer ce département ?')) { document.getElementById('delete-form').submit(); }"
                                class="btn-danger">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </div>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Mettre à Jour
                    </button>
                </div>
            </form>

            <!-- Formulaire de suppression caché -->
            <form id="delete-form" method="POST" action="{{ route('departements.delete', $departement->id) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <!-- Statistiques du département -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques du Département</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                <p class="text-sm text-gray-600">Employés</p>
                <p class="text-2xl font-bold text-blue-600">{{ $departement->employers->count() }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                <p class="text-sm text-gray-600">Masse Salariale</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($departement->employers->sum('montant_journalier') * 22, 0) }} XOF</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                <p class="text-sm text-gray-600">Salaire Moyen</p>
                <p class="text-2xl font-bold text-purple-600">{{ $departement->employers->count() > 0 ? number_format($departement->employers->avg('montant_journalier') * 22, 0) : 0 }} XOF</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                <p class="text-sm text-gray-600">Budget Utilisé</p>
                <p class="text-2xl font-bold text-orange-600">
                    @if($departement->budget_mensuel)
                        {{ number_format(($departement->employers->sum('montant_journalier') * 22 / $departement->budget_mensuel) * 100, 1) }}%
                    @else
                        N/A
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection