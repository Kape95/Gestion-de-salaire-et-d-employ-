@extends('layouts.app')

@section('title', 'Nouvel Employé')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Nouvel Employé</h1>
            <p class="text-gray-600 mt-1">Ajoutez un nouvel employé à votre équipe</p>
        </div>
        <a href="{{ route('employers.index') }}" class="btn-outline">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>

    <!-- Form -->
    <div class="glass-card p-8" x-data="{ loading: false, showPassword: false }">
        <form method="POST" action="{{ route('employers.store') }}" @submit="loading = true">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nom" 
                        name="nom" 
                        value="{{ old('nom') }}"
                        required 
                        class="input-modern @error('nom') border-red-500 @enderror"
                        placeholder="Nom de famille"
                    >
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                        Prénom <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="prenom" 
                        name="prenom" 
                        value="{{ old('prenom') }}"
                        required 
                        class="input-modern @error('prenom') border-red-500 @enderror"
                        placeholder="Prénom"
                    >
                    @error('prenom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            class="input-modern pl-10 @error('email') border-red-500 @enderror"
                            placeholder="email@exemple.com"
                        >
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact -->
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input 
                            type="tel" 
                            id="contact" 
                            name="contact" 
                            value="{{ old('contact') }}"
                            required 
                            class="input-modern pl-10 @error('contact') border-red-500 @enderror"
                            placeholder="+225 0123456789"
                        >
                    </div>
                    @error('contact')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Département -->
                <div>
                    <label for="departement_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Département <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="departement_id" 
                        name="departement_id" 
                        required 
                        class="input-modern @error('departement_id') border-red-500 @enderror"
                    >
                        <option value="">Sélectionner un département</option>
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}" {{ old('departement_id') == $departement->id ? 'selected' : '' }}>
                                {{ $departement->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('departement_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Poste -->
                <div>
                    <label for="poste" class="block text-sm font-medium text-gray-700 mb-2">
                        Poste / Fonction
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-briefcase text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            id="poste" 
                            name="poste" 
                            value="{{ old('poste') }}"
                            class="input-modern pl-10 @error('poste') border-red-500 @enderror"
                            placeholder="Ex: Développeur, Comptable, Manager..."
                        >
                    </div>
                    @error('poste')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salaire Journalier -->
                <div>
                    <label for="montant_journalier" class="block text-sm font-medium text-gray-700 mb-2">
                        Salaire Journalier (FCFA) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-money-bill-wave text-gray-400"></i>
                        </div>
                        <input 
                            type="number" 
                            id="montant_journalier" 
                            name="montant_journalier" 
                            value="{{ old('montant_journalier') }}"
                            required 
                            min="0"
                            step="100"
                            class="input-modern pl-10 @error('montant_journalier') border-red-500 @enderror"
                            placeholder="5000"
                        >
                    </div>
                    @error('montant_journalier')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations supplémentaires</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date de naissance -->
                    <div>
                        <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-2">
                            Date de naissance
                        </label>
                        <input 
                            type="date" 
                            id="date_naissance" 
                            name="date_naissance" 
                            value="{{ old('date_naissance') }}"
                            class="input-modern"
                        >
                    </div>

                    <!-- Date d'embauche -->
                    <div>
                        <label for="date_embauche" class="block text-sm font-medium text-gray-700 mb-2">
                            Date d'embauche
                        </label>
                        <input 
                            type="date" 
                            id="date_embauche" 
                            name="date_embauche" 
                            value="{{ old('date_embauche', date('Y-m-d')) }}"
                            class="input-modern"
                        >
                    </div>

                    <!-- Adresse -->
                    <div class="md:col-span-2">
                        <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse complète
                        </label>
                        <textarea 
                            id="adresse" 
                            name="adresse" 
                            rows="3"
                            class="input-modern resize-none"
                            placeholder="Adresse complète de l'employé"
                        >{{ old('adresse') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a 
                    href="{{ route('employers.index') }}" 
                    class="btn-outline"
                    :disabled="loading"
                >
                    Annuler
                </a>
                <button 
                    type="submit" 
                    class="btn-primary flex items-center"
                    :disabled="loading"
                >
                    <span x-show="!loading">Créer l'employé</span>
                    <span x-show="loading" class="flex items-center">
                        <div class="loading-spinner mr-2"></div>
                        Création en cours...
                    </span>
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Card -->
    <div class="glass-card p-6" x-data="{ showPreview: false }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Aperçu de l'employé</h3>
            <button 
                @click="showPreview = !showPreview"
                class="text-primary-600 hover:text-primary-700 text-sm font-medium"
            >
                <span x-show="!showPreview">Afficher l'aperçu</span>
                <span x-show="showPreview">Masquer l'aperçu</span>
            </button>
        </div>
        
        <div x-show="showPreview" x-transition class="bg-white/50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full flex items-center justify-center mr-4">
                    <span class="text-white font-bold text-lg" x-text="(document.getElementById('nom')?.value?.charAt(0) || '') + (document.getElementById('prenom')?.value?.charAt(0) || '')"></span>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900" x-text="(document.getElementById('nom')?.value || 'Nom') + ' ' + (document.getElementById('prenom')?.value || 'Prénom')"></h4>
                    <p class="text-gray-600" x-text="document.getElementById('email')?.value || 'email@exemple.com'"></p>
                    <p class="text-sm text-gray-500" x-text="document.getElementById('contact')?.value || 'Téléphone'"></p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-primary-600" x-text="(document.getElementById('montant_journalier')?.value || '0') + ' FCFA'"></p>
                    <p class="text-sm text-gray-500">Salaire journalier</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview updates
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['nom', 'prenom', 'email', 'contact', 'montant_journalier'];
    inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', function() {
                // Trigger Alpine.js reactivity
                Alpine.store('previewData', {
                    nom: document.getElementById('nom')?.value || '',
                    prenom: document.getElementById('prenom')?.value || '',
                    email: document.getElementById('email')?.value || '',
                    contact: document.getElementById('contact')?.value || '',
                    montant_journalier: document.getElementById('montant_journalier')?.value || ''
                });
            });
        }
    });
});
</script>
@endsection