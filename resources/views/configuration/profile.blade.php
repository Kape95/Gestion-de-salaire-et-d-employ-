@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier le Profil</h1>
            <p class="text-gray-600 mt-2">Mettez à jour vos informations personnelles</p>
        </div>
        <a href="{{ route('configuration.index') }}" class="btn-outline">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour
        </a>
    </div>

    <!-- Formulaire de modification du profil -->
    <div class="glass-card p-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('configuration.update-profile') }}">
            @csrf
            @method('PUT')

            <!-- Informations personnelles -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                    Informations Personnelles
                </h3>

                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}"
                        class="input-modern @error('name') border-red-500 @enderror"
                        required
                    >
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}"
                        class="input-modern @error('email') border-red-500 @enderror"
                        required
                    >
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Modification du mot de passe -->
            <div class="space-y-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                    Modifier le Mot de Passe
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Laissez vide si vous ne souhaitez pas changer votre mot de passe.
                </p>

                <!-- Mot de passe actuel -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe actuel
                    </label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password"
                        class="input-modern @error('current_password') border-red-500 @enderror"
                    >
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Nouveau mot de passe
                    </label>
                    <input 
                        type="password" 
                        id="new_password" 
                        name="new_password"
                        class="input-modern @error('new_password') border-red-500 @enderror"
                    >
                    @error('new_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation du nouveau mot de passe -->
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le nouveau mot de passe
                    </label>
                    <input 
                        type="password" 
                        id="new_password_confirmation" 
                        name="new_password_confirmation"
                        class="input-modern"
                    >
                </div>
            </div>

            <!-- Informations du compte -->
            <div class="space-y-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                    Informations du Compte
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600">Membre depuis</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-600">Dernière modification</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('configuration.index') }}" class="btn-outline">
                    Annuler
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer les Modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
