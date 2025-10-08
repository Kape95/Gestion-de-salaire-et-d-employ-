

@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Nouveau Département</h1>
            <p class="text-gray-600 mt-2">Créez un nouveau département pour votre organisation</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('departements.index') }}" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux Départements
            </a>
        </div>
    </div>

    <!-- Formulaire de création -->
    <div class="glass-card p-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Informations du Département</h2>
                <p class="text-gray-600">Remplissez les informations ci-dessous pour créer un nouveau département</p>
            </div>

            <form method="POST" action="{{ route('departements.store') }}" class="space-y-6">
                @csrf
                
                <!-- Nom du département -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du Département <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
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
                              placeholder="Décrivez les responsabilités et objectifs de ce département...">{{ old('description') }}</textarea>
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
                           value="{{ old('budget_mensuel') }}"
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
                        <option value="actif" {{ old('status') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ old('status') == 'inactif' ? 'selected' : '' }}>Inactif</option>
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
                               value="{{ old('couleur', '#3B82F6') }}"
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
                            <option value="{{ $employer->id }}" {{ old('responsable_id') == $employer->id ? 'selected' : '' }}>
                                {{ $employer->prenom }} {{ $employer->nom }} - {{ $employer->poste }}
                            </option>
                        @endforeach
                    </select>
                    @error('responsable_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('departements.index') }}" class="btn-outline">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Créer le Département
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Aperçu en temps réel -->
    <div class="glass-card p-6" x-data="{ 
        name: '{{ old('name') }}',
        description: '{{ old('description') }}',
        status: '{{ old('status', 'actif') }}',
        couleur: '{{ old('couleur', '#3B82F6') }}'
    }">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aperçu du Département</h3>
        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center mb-4">
                <div class="w-4 h-4 rounded-full mr-3" :style="`background-color: ${couleur}`"></div>
                <h4 class="text-xl font-semibold text-gray-900" x-text="name || 'Nom du département'"></h4>
                <span class="ml-auto px-3 py-1 rounded-full text-xs font-medium"
                      :class="status === 'actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                      x-text="status === 'actif' ? 'Actif' : 'Inactif'"></span>
            </div>
            <p class="text-gray-600 mb-4" x-text="description || 'Description du département...'"></p>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Budget:</span>
                    <span class="font-medium">{{ old('budget_mensuel') ? number_format(old('budget_mensuel'), 2) . ' XOF' : 'Non défini' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Responsable:</span>
                    <span class="font-medium">
                        @if(old('responsable_id'))
                            @php $responsable = \App\Models\Employer::find(old('responsable_id')); @endphp
                            {{ $responsable ? $responsable->prenom . ' ' . $responsable->nom : 'Non assigné' }}
                        @else
                            Non assigné
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mise à jour en temps réel de l'aperçu
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const statusSelect = document.getElementById('status');
    const couleurInput = document.getElementById('couleur');

    if (nameInput) {
        nameInput.addEventListener('input', function() {
            Alpine.store('departmentPreview', { name: this.value });
        });
    }

    if (descriptionInput) {
        descriptionInput.addEventListener('input', function() {
            Alpine.store('departmentPreview', { description: this.value });
        });
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            Alpine.store('departmentPreview', { status: this.value });
        });
    }

    if (couleurInput) {
        couleurInput.addEventListener('input', function() {
            Alpine.store('departmentPreview', { couleur: this.value });
        });
    }
});
</script>
@endsection