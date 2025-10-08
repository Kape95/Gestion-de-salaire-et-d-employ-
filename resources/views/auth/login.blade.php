<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <!-- ===========================================
    SECTION HEAD - CONFIGURATION DE BASE DE LA PAGE
    =========================================== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Token CSRF pour la sécurité des formulaires Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Titre dynamique de la page avec fallback -->
    <title>{{ config('app.name', 'Gestion Salaires') }} - Connexion</title>
    
    <!-- ===========================================
    RESSOURCES EXTERNES - POLICES ET ICÔNES
    =========================================== -->
    <!-- Google Fonts - Police Inter pour une typographie moderne -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome - Bibliothèque d'icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- ===========================================
    FRAMEWORKS CSS ET JAVASCRIPT
    =========================================== -->
    <!-- Tailwind CSS - Framework CSS utilitaire pour le design -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js - Framework JavaScript léger pour l'interactivité -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- ===========================================
    STYLES PERSONNALISÉS - CSS CUSTOM
    =========================================== -->
    <style>
        /* Masque les éléments Alpine.js pendant le chargement */
        [x-cloak] { display: none !important; }
        
        /* ===========================================
        EFFET GLASSMORPHISM - CARTE TRANSPARENTE
        =========================================== */
        .glass-card {
            /* Fond semi-transparent avec effet de flou */
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            /* Bordure subtile pour définir les contours */
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            /* Ombre portée pour la profondeur */
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        /* ===========================================
        BOUTON PRIMAIRE MODERNE
        =========================================== */
        .btn-primary {
            /* Dégradé de couleur bleu moderne */
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
            /* Animation de transition fluide */
            transition: all 0.2s;
            transform: scale(1);
            width: 100%;
        }
        
        /* Effet hover avec changement de couleur et légère animation */
        .btn-primary:hover {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            transform: scale(1.02);
        }
        
        /* ===========================================
        CHAMP DE SAISIE MODERNE
        =========================================== */
        .input-modern {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.2s;
            /* Fond semi-transparent avec effet de flou */
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(4px);
        }
        
        /* Focus avec bordure colorée et ombre */
        .input-modern:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* ===========================================
        SECTION IDENTIFIANTS DE DÉMONSTRATION
        =========================================== */
        .demo-credentials {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            padding: 16px;
            margin-top: 24px;
        }
        
        .demo-credentials h4 {
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .demo-credentials p {
            font-size: 14px;
            opacity: 0.9;
        }
    </style>
</head>

<!-- ===========================================
CORPS DE LA PAGE - STRUCTURE PRINCIPALE
=========================================== -->
<body class="h-full bg-gradient-to-br from-blue-50 via-white to-purple-50 font-sans">
    <!-- Conteneur principal centré -->
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            
            <!-- ===========================================
            EN-TÊTE AVEC LOGO ET TITRE
            =========================================== -->
            <div class="text-center">
                <!-- Logo avec icône et dégradé -->
                <div class="mx-auto w-20 h-20 bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-chart-line text-white text-3xl"></i>
                </div>
                <!-- Titre principal de l'application -->
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Gestion des Salaires
                </h2>
                <!-- Sous-titre descriptif -->
                <p class="text-gray-600 text-lg">
                    et Employés
                </p>
                <p class="text-gray-600">
                    Connectez-vous à votre compte
                </p>
            </div>

            <!-- ===========================================
            FORMULAIRE DE CONNEXION
            =========================================== -->
            <div class="glass-card p-8" x-data="{ loading: false, showPassword: false }">
                
                <!-- ===========================================
                AFFICHAGE DES ERREURS DE VALIDATION
                =========================================== -->
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <div>
                                <p class="text-red-800 font-medium">Erreur de connexion</p>
                                <p class="text-red-600 text-sm">
                                    @foreach($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- ===========================================
                FORMULAIRE PRINCIPAL
                =========================================== -->
                <form method="POST" action="{{ route('handleLogin') }}" @submit="loading = true">
                    <!-- Token CSRF pour la sécurité -->
                    @csrf
                    
                    <!-- ===========================================
                    CHAMP EMAIL
                    =========================================== -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse email
                        </label>
                        <div class="relative">
                            <!-- Icône à gauche du champ -->
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <!-- Champ de saisie email -->
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                value="{{ old('email') }}"
                                class="input-modern pl-10"
                                placeholder="votre@email.com"
                                autocomplete="email"
                            >
                        </div>
                    </div>

                    <!-- ===========================================
                    CHAMP MOT DE PASSE
                    =========================================== -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <!-- Icône à gauche du champ -->
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <!-- Champ de saisie mot de passe avec toggle visibilité -->
                            <input 
                                id="password" 
                                name="password" 
                                :type="showPassword ? 'text' : 'password'" 
                                required 
                                class="input-modern pl-10 pr-12"
                                placeholder="Votre mot de passe"
                                autocomplete="current-password"
                            >
                            <!-- Bouton pour afficher/masquer le mot de passe -->
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            >
                                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ===========================================
                    OPTIONS SUPPLÉMENTAIRES
                    =========================================== -->
                    <div class="flex items-center justify-between mb-6">
                        <!-- Case à cocher "Se souvenir de moi" -->
                        <div class="flex items-center">
                            <input 
                                id="remember" 
                                name="remember" 
                                type="checkbox" 
                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Se souvenir de moi
                            </label>
                        </div>
                        
                        <!-- Lien "Mot de passe oublié" -->
                        <div class="text-sm">
                            <a href="#" class="text-primary-600 hover:text-primary-700 font-medium">
                                Mot de passe oublié ?
                            </a>
                        </div>
                    </div>

                    <!-- ===========================================
                    BOUTON DE SOUMISSION
                    =========================================== -->
                    <button 
                        type="submit" 
                        :disabled="loading"
                        class="w-full btn-primary flex items-center justify-center"
                    >
                        <!-- Texte normal -->
                        <span x-show="!loading">Se connecter</span>
                        <!-- Texte pendant le chargement -->
                        <span x-show="loading" class="flex items-center">
                            <div class="loading-spinner mr-2"></div>
                            Connexion en cours...
                        </span>
                    </button>
                </form>

                <!-- ===========================================
                SÉPARATEUR VISUEL
                =========================================== -->
                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou</span>
                        </div>
                    </div>
                </div>

                <!-- ===========================================
                IDENTIFIANTS DE DÉMONSTRATION
                =========================================== -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Identifiants de démonstration
                    </h4>
                    <div class="text-xs text-blue-700 space-y-1">
                        <p><strong>Email:</strong> admin@example.com</p>
                        <p><strong>Mot de passe:</strong> password</p>
                    </div>
                </div>
            </div>

            <!-- ===========================================
            PIED DE PAGE
            =========================================== -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    © {{ date('Y') }} Gestion Salaires. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>

    <!-- ===========================================
    ANIMATION DE FOND - EFFETS VISUELS
    =========================================== -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <!-- Fond dégradé principal -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50"></div>
        <!-- Formes animées floues pour l'effet de profondeur -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <!-- ===========================================
    ANIMATIONS CSS - KEYFRAMES
    =========================================== -->
    <style>
        /* Animation de mouvement des formes de fond */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>