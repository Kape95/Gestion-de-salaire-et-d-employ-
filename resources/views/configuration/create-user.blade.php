@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Ajouter un Utilisateur</h1>
            <p class="text-gray-600 mt-2">Créez un nouveau compte utilisateur</p>
        </div>
        <a href="{{ route('configuration.users') }}" class="btn-outline">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="glass-card p-8">
        <form method="POST" action="{{ route('configuration.store-user') }}">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="input-modern @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="input-modern @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" name="password"
                           class="input-modern @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le mot de passe <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="input-modern" required>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('configuration.users') }}" class="btn-outline">Annuler</a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-user-plus mr-2"></i>Créer l'Utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
