<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <a href="{{ route('sites.create') }}" class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-indigo-800 text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create New Site
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Sites Card -->
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-indigo-100 text-sm font-medium mb-1">Total Sites</p>
                                <p class="text-4xl font-bold">{{ $totalSites }}</p>
                                <p class="text-indigo-100 text-xs mt-2">All WordPress sites</p>
                            </div>
                            <div class="bg-white/20 rounded-full p-4">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Sites Card -->
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium mb-1">Active Sites</p>
                                <p class="text-4xl font-bold">{{ $activeSites }}</p>
                                <p class="text-green-100 text-xs mt-2">{{ $totalSites > 0 ? round(($activeSites / $totalSites) * 100) : 0 }}% of total</p>
                            </div>
                            <div class="bg-white/20 rounded-full p-4">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Sites Card -->
                <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm font-medium mb-1">Error Sites</p>
                                <p class="text-4xl font-bold">{{ $errorSites }}</p>
                                <p class="text-red-100 text-xs mt-2">Requires attention</p>
                            </div>
                            <div class="bg-white/20 rounded-full p-4">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disabled Sites Card -->
                <div class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-100 text-sm font-medium mb-1">Disabled Sites</p>
                                <p class="text-4xl font-bold">{{ $disabledSites }}</p>
                                <p class="text-gray-100 text-xs mt-2">Currently offline</p>
                            </div>
                            <div class="bg-white/20 rounded-full p-4">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Backups -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Recent Backups
                            </h3>
                            <a href="{{ route('sites.index') }}" class="text-blue-100 hover:text-white text-sm font-medium">View All</a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($lastBackups->count() > 0)
                            <div class="space-y-3">
                                @foreach($lastBackups as $backup)
                                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-lg hover:shadow-md transition-all duration-200 border-l-4 {{ $backup->status === 'success' ? 'border-green-500' : 'border-red-500' }}">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    @if($backup->status === 'success')
                                                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $backup->site->domain }}</p>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $backup->created_at->format('M d, Y') }}</p>
                                                        <span class="text-gray-400">•</span>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $backup->created_at->format('H:i') }}</p>
                                                        @if($backup->size_mb)
                                                            <span class="text-gray-400">•</span>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($backup->size_mb, 2) }} MB</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="ml-4 px-3 py-1.5 text-xs font-bold rounded-full uppercase tracking-wide {{ $backup->status === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ $backup->status }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No backups yet</p>
                                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Create your first backup to see it here</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Expiring SSL Certificates -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Expiring SSL Certificates
                            </h3>
                            <span class="text-amber-100 text-sm font-medium">Next 30 Days</span>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($expiringCertificates->count() > 0)
                            <div class="space-y-3">
                                @foreach($expiringCertificates as $cert)
                                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-gray-700 dark:to-gray-600 rounded-lg hover:shadow-md transition-all duration-200 border-l-4 border-amber-500">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $cert->domain }}</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                        Expires: <span class="font-medium">{{ $cert->expires_at->format('M d, Y') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-4 text-right">
                                            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200">
                                                {{ $cert->expires_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">All certificates are valid</p>
                                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">No certificates expiring in the next 30 days</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('sites.create') }}" class="group flex items-center p-5 bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900 dark:to-indigo-800 rounded-xl hover:from-indigo-100 hover:to-indigo-200 dark:hover:from-indigo-800 dark:hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1 border border-indigo-200 dark:border-indigo-700">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="font-bold text-gray-900 dark:text-white">Create New Site</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Set up a new WordPress site</p>
                            </div>
                            <svg class="w-5 h-5 text-indigo-500 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="{{ route('sites.index') }}" class="group flex items-center p-5 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900 dark:to-green-800 rounded-xl hover:from-green-100 hover:to-green-200 dark:hover:from-green-800 dark:hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1 border border-green-200 dark:border-green-700">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="font-bold text-gray-900 dark:text-white">View All Sites</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Manage your WordPress sites</p>
                            </div>
                            <svg class="w-5 h-5 text-green-500 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <div class="group flex items-center p-5 bg-gradient-to-br from-purple-50 to-pink-100 dark:from-purple-900 dark:to-purple-800 rounded-xl border border-purple-200 dark:border-purple-700 shadow-md">
                            <div class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="font-bold text-gray-900 dark:text-white">System Status</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">All systems operational</p>
                            </div>
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
