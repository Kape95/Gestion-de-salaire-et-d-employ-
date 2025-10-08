@extends('layouts.app')

@section('title', 'Modifier Employé')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier Employé</h1>
            <p class="text-gray-600 mt-1">Modifiez les informations de {{ $employer->nom }} {{ $employer->prenom }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('employers.index') }}" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
            <a href="{{ route('employers.create') }}" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Nouvel Employé
            </a>
        </div>
    </div>

    <!-- Employee Info Card -->
    <div class="glass-card p-6">
        <div class="flex items-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full flex items-center justify-center mr-4">
                <span class="text-white font-bold text-xl">
                    {{ substr($employer->nom, 0, 1) }}{{ substr($employer->prenom, 0, 1) }}
                </span>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900">{{ $employer->nom }} {{ $employer->prenom }}</h2>
                <p class="text-gray-600">{{ $employer->email }}</p>
                <p class="text-sm text-gray-500">Employé depuis {{ $employer->created_at->format('d/m/Y') }}</p>
            </div>
            <div class="text-right">
                <p class="text-lg font-bold text-primary-600">{{ number_format($employer->montant_journalier, 0, ',', ' ') }} FCFA</p>
                <p class="text-sm text-gray-500">Salaire journalier</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-card p-8" x-data="{ loading: false, showPassword: false }">
        <form method="POST" action="{{ route('employers.update', $employer) }}" @submit="loading = true">
            @csrf
            @method('PUT')
            
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
                        value="{{ old('nom', $employer->nom) }}"
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
                        value="{{ old('prenom', $employer->prenom) }}"
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
                            value="{{ old('email', $employer->email) }}"
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
                            value="{{ old('contact', $employer->contact) }}"
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
                            <option value="{{ $departement->id }}" {{ old('departement_id', $employer->departement_id) == $departement->id ? 'selected' : '' }}>
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
                            value="{{ old('poste', $employer->poste) }}"
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
                            value="{{ old('montant_journalier', $employer->montant_journalier) }}"
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
                            value="{{ old('date_naissance', $employer->date_naissance ? \Carbon\Carbon::parse($employer->date_naissance)->format('Y-m-d') : '') }}"
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
                            value="{{ old('date_embauche', $employer->date_embauche ? \Carbon\Carbon::parse($employer->date_embauche)->format('Y-m-d') : $employer->created_at->format('Y-m-d')) }}"
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
                        >{{ old('adresse', $employer->adresse ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-4">
                    <button 
                        type="button"
                        @click="deleteEmployer({{ $employer->id }})"
                        class="btn-secondary bg-red-500 hover:bg-red-600"
                        :disabled="loading"
                    >
                        <i class="fas fa-trash mr-2"></i>
                        Supprimer l'employé
                    </button>
                </div>
                
                <div class="flex items-center space-x-4">
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
                        <span x-show="!loading">Mettre à jour</span>
                        <span x-show="loading" class="flex items-center">
                            <div class="loading-spinner mr-2"></div>
                            Mise à jour en cours...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistics Card -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques de l'employé</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ number_format($employer->montant_journalier * 22, 0, ',', ' ') }}</div>
                <p class="text-sm text-gray-600">Salaire mensuel estimé</p>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ $employer->created_at->diffForHumans() }}</div>
                <p class="text-sm text-gray-600">Dans l'entreprise</p>
            </div>
            
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ $employer->departement->name ?? 'N/A' }}</div>
                <p class="text-sm text-gray-600">Département</p>
            </div>
        </div>
    </div>
</div>



<script>
function deleteEmployer(id) {
    // Utiliser la même approche simple que dans le dashboard
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