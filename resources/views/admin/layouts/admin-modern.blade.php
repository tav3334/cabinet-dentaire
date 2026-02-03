<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Cabinet Dentaire</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="h-full" x-data="{ sidebarOpen: false, notificationOpen: false }">

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50">

        <!-- Sidebar Mobile Backdrop -->
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900 bg-opacity-75 z-40 lg:hidden">
        </div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 ease-in-out lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="flex flex-col h-full bg-gradient-to-b from-purple-600 via-purple-700 to-purple-900 shadow-2xl">

                <!-- Brand -->
                <div class="flex items-center justify-center h-20 px-6 bg-black bg-opacity-20 border-b border-purple-500 border-opacity-30">
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center text-white group">
                        <div class="p-3 bg-white bg-opacity-20 rounded-2xl backdrop-blur-sm group-hover:bg-opacity-30 transition-all duration-300">
                            <i class="bi bi-hospital text-3xl"></i>
                        </div>
                        <span class="mt-2 font-bold text-sm tracking-wide">Cabinet Dentaire</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">

                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-white bg-opacity-25 shadow-lg' : 'hover:bg-white hover:bg-opacity-15' }}">
                        <i class="bi bi-speedometer2 text-xl w-6"></i>
                        <span class="ml-3 font-medium">Tableau de bord</span>
                        @if(request()->routeIs('admin.dashboard'))
                            <div class="ml-auto w-1 h-8 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.appointments.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl transition-all duration-200 group relative {{ request()->routeIs('admin.appointments.*') ? 'bg-white bg-opacity-25 shadow-lg' : 'hover:bg-white hover:bg-opacity-15' }}">
                        <i class="bi bi-calendar-check text-xl w-6"></i>
                        <span class="ml-3 font-medium">Rendez-vous</span>
                        @php
                            $pendingCount = \App\Models\Appointment::where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="ml-auto px-2 py-1 text-xs font-bold text-purple-900 bg-amber-400 rounded-full animate-pulse">
                                {{ $pendingCount }}
                            </span>
                        @endif
                        @if(request()->routeIs('admin.appointments.*'))
                            <div class="ml-auto w-1 h-8 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.patients.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.patients.*') ? 'bg-white bg-opacity-25 shadow-lg' : 'hover:bg-white hover:bg-opacity-15' }}">
                        <i class="bi bi-people text-xl w-6"></i>
                        <span class="ml-3 font-medium">Patients</span>
                        @if(request()->routeIs('admin.patients.*'))
                            <div class="ml-auto w-1 h-8 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.treatments.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.treatments.*') ? 'bg-white bg-opacity-25 shadow-lg' : 'hover:bg-white hover:bg-opacity-15' }}">
                        <i class="bi bi-prescription2 text-xl w-6"></i>
                        <span class="ml-3 font-medium">Traitements</span>
                        @if(request()->routeIs('admin.treatments.*'))
                            <div class="ml-auto w-1 h-8 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.consultations.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.consultations.*') ? 'bg-white bg-opacity-25 shadow-lg' : 'hover:bg-white hover:bg-opacity-15' }}">
                        <i class="bi bi-clipboard2-pulse text-xl w-6"></i>
                        <span class="ml-3 font-medium">Consultations</span>
                        @if(request()->routeIs('admin.consultations.*'))
                            <div class="ml-auto w-1 h-8 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.medical-files.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.medical-files.*') ? 'bg-white bg-opacity-25 shadow-lg' : 'hover:bg-white hover:bg-opacity-15' }}">
                        <i class="bi bi-file-earmark-medical text-xl w-6"></i>
                        <span class="ml-3 font-medium">Fichiers Médicaux</span>
                        @if(request()->routeIs('admin.medical-files.*'))
                            <div class="ml-auto w-1 h-8 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.services.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.services.*') ? 'bg-white bg-opacity-25 shadow-lg' : 'hover:bg-white hover:bg-opacity-15' }}">
                        <i class="bi bi-gear text-xl w-6"></i>
                        <span class="ml-3 font-medium">Services</span>
                        @if(request()->routeIs('admin.services.*'))
                            <div class="ml-auto w-1 h-8 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <!-- Divider -->
                    <div class="py-3">
                        <div class="border-t border-purple-500 border-opacity-30"></div>
                    </div>

                    <a href="{{ url('/') }}" target="_blank"
                       class="flex items-center px-4 py-3 text-white rounded-xl transition-all duration-200 hover:bg-white hover:bg-opacity-15">
                        <i class="bi bi-box-arrow-up-right text-xl w-6"></i>
                        <span class="ml-3 font-medium">Voir le site</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-white rounded-xl transition-all duration-200 hover:bg-red-500 hover:bg-opacity-20">
                            <i class="bi bi-box-arrow-left text-xl w-6"></i>
                            <span class="ml-3 font-medium">Déconnexion</span>
                        </button>
                    </form>
                </nav>

                <!-- User Info -->
                <div class="p-4 bg-black bg-opacity-20 border-t border-purple-500 border-opacity-30">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-purple-200 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-64">

            <!-- Top Navigation Bar -->
            <header class="sticky top-0 z-30 bg-white bg-opacity-80 backdrop-blur-xl border-b border-gray-200 shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">

                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = true"
                                class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                            <i class="bi bi-list text-2xl"></i>
                        </button>

                        <!-- Page Title -->
                        <div class="flex-1 flex items-center px-4">
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                @yield('page-title', 'Tableau de bord')
                            </h1>
                        </div>

                        <!-- Right Side Actions -->
                        <div class="flex items-center space-x-4">

                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                        class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors relative">
                                    <i class="bi bi-bell text-xl"></i>
                                    @if($pendingCount > 0)
                                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                    @endif
                                </button>

                                <!-- Notifications Dropdown -->
                                <div x-show="open"
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
                                     style="display: none;">
                                    <div class="p-4 bg-gradient-to-r from-purple-600 to-pink-600">
                                        <h3 class="text-white font-semibold">Notifications</h3>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @if($pendingCount > 0)
                                            <a href="{{ route('admin.appointments.index') }}" class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                                                            <i class="bi bi-calendar-check text-amber-600"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-3 flex-1">
                                                        <p class="text-sm font-medium text-gray-900">Rendez-vous en attente</p>
                                                        <p class="text-xs text-gray-500 mt-1">{{ $pendingCount }} rendez-vous nécessitent votre attention</p>
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            <div class="p-8 text-center text-gray-500">
                                                <i class="bi bi-bell-slash text-4xl mb-2"></i>
                                                <p class="text-sm">Aucune notification</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- User Badge -->
                            <div class="hidden sm:flex items-center px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 rounded-full">
                                <i class="bi bi-shield-check text-purple-600 mr-2"></i>
                                <span class="text-sm font-semibold text-purple-700">Admin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">

                <!-- Alerts -->
                @if(session('success'))
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-init="setTimeout(() => show = false, 5000)"
                         class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl shadow-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-check-circle-fill text-2xl text-green-600"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="ml-4 text-green-600 hover:text-green-800">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-init="setTimeout(() => show = false, 5000)"
                         class="mb-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl shadow-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-exclamation-circle-fill text-2xl text-red-600"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                            <button @click="show = false" class="ml-4 text-red-600 hover:text-red-800">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Main Content Area -->
                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
