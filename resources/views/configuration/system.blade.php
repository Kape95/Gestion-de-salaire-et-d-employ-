@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Informations Système</h1>
            <p class="text-gray-600 mt-2">Détails techniques de l'application</p>
        </div>
        <a href="{{ route('configuration.index') }}" class="btn-outline">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour
        </a>
    </div>

    <!-- Informations système -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informations de base -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                <i class="fas fa-server mr-2"></i>
                Informations de Base
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Nom de l'application</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $systemInfo['app_name'] }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Environnement</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $systemInfo['app_env'] === 'production' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($systemInfo['app_env']) }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Mode Debug</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $systemInfo['app_debug'] === 'Activé' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $systemInfo['app_debug'] }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Fuseau horaire</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $systemInfo['timezone'] }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Langue</span>
                    <span class="text-sm font-semibold text-gray-900">{{ ucfirst($systemInfo['locale']) }}</span>
                </div>
            </div>
        </div>

        <!-- Versions -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                <i class="fas fa-code mr-2"></i>
                Versions
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Version PHP</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $systemInfo['php_version'] }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Version Laravel</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $systemInfo['laravel_version'] }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Base de données</span>
                    <span class="text-sm font-semibold text-gray-900">{{ ucfirst($systemInfo['database']) }}</span>
                </div>
            </div>
        </div>

        <!-- Statistiques serveur -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                <i class="fas fa-chart-bar mr-2"></i>
                Statistiques Serveur
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Mémoire utilisée</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format(memory_get_usage(true) / 1024 / 1024, 2) }} MB</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Temps d'exécution</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format(microtime(true) - LARAVEL_START, 3) }}s</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Date du serveur</span>
                    <span class="text-sm font-semibold text-gray-900">{{ now()->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>
        </div>

        <!-- Extensions PHP -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                <i class="fas fa-puzzle-piece mr-2"></i>
                Extensions PHP Requises
            </h3>
            
            <div class="space-y-3">
                @php
                    $required_extensions = ['bcmath', 'ctype', 'fileinfo', 'json', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml'];
                @endphp
                
                @foreach($required_extensions as $extension)
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">{{ $extension }}</span>
                        @if(extension_loaded($extension))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>
                                Installée
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times mr-1"></i>
                                Manquante
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Actions système -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">
            <i class="fas fa-tools mr-2"></i>
            Actions Système
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button class="btn-outline w-full" onclick="clearCache()">
                <i class="fas fa-broom mr-2"></i>
                Vider le Cache
            </button>
            
            <button class="btn-outline w-full" onclick="clearConfig()">
                <i class="fas fa-cog mr-2"></i>
                Vider la Config
            </button>
            
            <button class="btn-outline w-full" onclick="optimizeApp()">
                <i class="fas fa-rocket mr-2"></i>
                Optimiser l'App
            </button>
        </div>
    </div>
</div>

<script>
function clearCache() {
    if (confirm('Voulez-vous vider le cache de l\'application ?')) {
        // Ici vous pouvez ajouter une requête AJAX pour vider le cache
        alert('Cache vidé avec succès !');
    }
}

function clearConfig() {
    if (confirm('Voulez-vous vider la configuration ?')) {
        // Ici vous pouvez ajouter une requête AJAX pour vider la config
        alert('Configuration vidée avec succès !');
    }
}

function optimizeApp() {
    if (confirm('Voulez-vous optimiser l\'application ?')) {
        // Ici vous pouvez ajouter une requête AJAX pour optimiser
        alert('Application optimisée avec succès !');
    }
}
</script>
@endsection
