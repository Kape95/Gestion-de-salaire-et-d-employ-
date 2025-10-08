@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Configuration</h1>
            <p class="text-gray-600 mt-2">Gérez les paramètres de votre application</p>
        </div>
    </div>

    <!-- Statistiques utilisateurs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Utilisateurs</p>
                    <p class="stat-number">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Connecté</p>
                    <p class="stat-number">{{ $user->name }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Dernière Connexion</p>
                    <p class="stat-number">{{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu de configuration -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Profil utilisateur -->
        <div class="glass-card p-6 flex flex-col">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-user text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Profil Utilisateur</h3>
                    <p class="text-sm text-gray-600">Modifiez vos informations personnelles</p>
                </div>
            </div>
            <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Nom:</span>
                    <span class="text-sm font-medium">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Email:</span>
                    <span class="text-sm font-medium">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Membre depuis:</span>
                    <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="mt-auto">
                <a href="{{ route('configuration.profile') }}" class="btn-primary w-full text-center">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier le Profil
                </a>
            </div>
        </div>

        <!-- Gestion des utilisateurs -->
        <div class="glass-card p-6 flex flex-col">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-users-cog text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Gestion Utilisateurs</h3>
                    <p class="text-sm text-gray-600">Gérez les comptes utilisateurs</p>
                </div>
            </div>
            <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Total utilisateurs:</span>
                    <span class="text-sm font-medium">{{ $totalUsers }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Utilisateurs récents:</span>
                    <span class="text-sm font-medium">{{ $recentUsers->count() }}</span>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2 mt-auto">
                <a href="{{ route('configuration.users') }}" class="btn-primary w-full text-center">
                    <i class="fas fa-list mr-2"></i>
                    Voir Tous les Utilisateurs
                </a>
                <a href="{{ route('configuration.create-user') }}" class="btn-outline w-full text-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Ajouter un Utilisateur
                </a>
            </div>
        </div>

        <!-- Informations système -->
        <div class="glass-card p-6 flex flex-col">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-server text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Système</h3>
                    <p class="text-sm text-gray-600">Informations techniques</p>
                </div>
            </div>
            <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Version PHP:</span>
                    <span class="text-sm font-medium">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Laravel:</span>
                    <span class="text-sm font-medium">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Environnement:</span>
                    <span class="text-sm font-medium">{{ config('app.env') }}</span>
                </div>
            </div>
            <div class="mt-auto">
                <a href="{{ route('configuration.system') }}" class="btn-primary w-full text-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Détails Système
                </a>
            </div>
        </div>
    </div>

    <!-- Utilisateurs récents -->
    <div class="glass-card p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Utilisateurs Récents</h2>
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Date de création</th>
                        <th>Dernière modification</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $recentUser)
                    <tr>
                        <td>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-semibold text-sm">
                                        {{ strtoupper(substr($recentUser->name, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $recentUser->name }}</p>
                                    <p class="text-sm text-gray-500">Utilisateur</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-sm text-gray-600">{{ $recentUser->email }}</td>
                        <td class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($recentUser->created_at)->format('d/m/Y H:i') }}</td>
                        <td class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($recentUser->updated_at)->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="flex space-x-2">
                                @if($recentUser->id !== $user->id)
                                <form method="POST" action="{{ route('configuration.delete-user', $recentUser->id) }}" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        <i class="fas fa-trash mr-1"></i>
                                        Supprimer
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 text-sm">Vous</span>
                                @endif
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
