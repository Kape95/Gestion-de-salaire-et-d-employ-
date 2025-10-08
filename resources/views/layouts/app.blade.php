<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Gestion Salaires') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        /* Modern Button */
        .btn-primary {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: white;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
            transform: scale(1);
        }
        
        .btn-primary:hover {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            transform: scale(1.05);
        }
        
        /* Sidebar */
        .sidebar {
            background: linear-gradient(to bottom, #1e40af, #1e3a8a);
            color: white;
            width: 256px;
            min-height: 100vh;
            padding: 24px;
            transition: all 0.3s;
        }
        
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-item.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }
        
        /* Dashboard Cards */
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .stat-card:hover {
            transform: scale(1.05);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            background: linear-gradient(to right, #3b82f6, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Modern Input */
        .input-modern {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.2s;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(4px);
        }
        
        .input-modern:focus {
            outline: none;
            ring: 2px;
            ring-color: #3b82f6;
            border-color: transparent;
        }
        
        /* Modern Table */
        .table-modern {
            width: 100%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(4px);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .table-modern th {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: white;
            font-weight: 600;
            padding: 16px 24px;
            text-align: left;
        }
        
        .table-modern td {
            padding: 16px 24px;
            border-bottom: 1px solid #e5e7eb;
            transition: colors 0.2s;
        }
        
        .table-modern tr:hover td {
            background: #f9fafb;
        }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-blue-50 via-white to-purple-50 font-sans">
    <div x-data="sidebar" class="flex h-full">
        <!-- Sidebar -->
        <div class="sidebar" :class="{ '-translate-x-full': !isOpen }" x-cloak>
            <!-- Logo -->
            <div class="flex items-center justify-center mb-8">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white">Gestion des Salaires</h1>
                    <p class="text-white/70 text-sm">et Employés</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('employers.index') }}" class="sidebar-item {{ request()->routeIs('employers.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>Employés</span>
                </a>
                
                <a href="{{ route('departements.index') }}" class="sidebar-item {{ request()->routeIs('departements.*') ? 'active' : '' }}">
                    <i class="fas fa-building w-5 h-5 mr-3"></i>
                    <span>Départements</span>
                </a>
                
                <a href="{{ route('salaires.index') }}" class="sidebar-item {{ request()->routeIs('salaires.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave w-5 h-5 mr-3"></i>
                    <span>Salaires</span>
                </a>
                
                <a href="{{ route('rapports.index') }}" class="sidebar-item {{ request()->routeIs('rapports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                    <span>Rapports</span>
                </a>
                
                <a href="{{ route('configuration.index') }}" class="sidebar-item {{ request()->routeIs('configuration.*') ? 'active' : '' }}">
                    <i class="fas fa-cog w-5 h-5 mr-3"></i>
                    <span>Configuration</span>
                </a>
            </nav>
            
            <!-- User Profile -->
            <div class="absolute bottom-6 left-6 right-6">
                <div class="glass-card p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium">{{ auth()->user()->name ?? 'Utilisateur' }}</p>
                            <p class="text-white/70 text-sm">Administrateur</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-white/70 hover:text-white transition-colors">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile Menu Button -->
                    <button @click="toggle" class="lg:hidden text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Breadcrumb -->
                    <div class="hidden lg:flex items-center space-x-2 text-sm text-gray-600">
                        <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
                        @if(request()->routeIs('employers.*'))
                            <i class="fas fa-chevron-right text-xs"></i>
                            <span>Employés</span>
                        @endif
                        @if(request()->routeIs('departements.*'))
                            <i class="fas fa-chevron-right text-xs"></i>
                            <span>Départements</span>
                        @endif
                    </div>
                    
                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- Search -->
                        <div class="relative hidden md:block">
                            <input type="text" placeholder="Rechercher..." class="input-modern w-64 pl-10">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="notification success mb-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>{{ session('success') }}</span>
                            <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="notification error mb-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <span>{{ session('error') }}</span>
                            <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Notifications Container -->
    <div id="notifications-container"></div>
    
    <!-- Scripts -->
    <script>
        // Global Alpine.js data
        window.appData = {
            user: @json(auth()->user()),
            csrfToken: '{{ csrf_token() }}',
            routes: {
                dashboard: '{{ route("dashboard") }}',
                employers: '{{ route("employers.index") }}',
                departements: '{{ route("departements.index") }}'
            }
        };
        
        // Alpine.js Data
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebar', () => ({
                isOpen: true,
                toggle() {
                    this.isOpen = !this.isOpen;
                }
            }));
            
            Alpine.data('notification', () => ({
                show: false,
                message: '',
                type: 'success',
                showNotification(message, type = 'success') {
                    this.message = message;
                    this.type = type;
                    this.show = true;
                    setTimeout(() => {
                        this.show = false;
                    }, 3000);
                }
            }));
            
            Alpine.data('modal', () => ({
                show: false,
                open() {
                    this.show = true;
                },
                close() {
                    this.show = false;
                }
            }));
        });
        
        // Utility functions
        function formatCurrency(amount) {
            return new Intl.NumberFormat('fr-FR', {
                style: 'currency',
                currency: 'EUR'
            }).format(amount);
        }
        
        function formatDate(date) {
            return new Date(date).toLocaleDateString('fr-FR');
        }
        
        function showLoading() {
            // Add loading indicator
        }
        
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text);
        }
        
        function showNotification(message, type = 'success') {
            // Show notification
        }
    </script>
</body>
</html>
