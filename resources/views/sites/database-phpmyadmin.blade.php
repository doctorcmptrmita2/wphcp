<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    phpMyAdmin - {{ $site->domain }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Database: {{ $database->name }}</p>
            </div>
            <a href="{{ route('sites.database', $site) }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Database
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Database Info -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">phpMyAdmin Access</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Click the button below to open phpMyAdmin with your database credentials pre-filled.
                </p>
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div>
                            <dt class="font-medium text-gray-700 dark:text-gray-300">Database:</dt>
                            <dd class="text-gray-900 dark:text-white font-mono">{{ $database->name }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700 dark:text-gray-300">Username:</dt>
                            <dd class="text-gray-900 dark:text-white font-mono">{{ $database->username }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700 dark:text-gray-300">Host:</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $database->host }}:{{ $database->port }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700 dark:text-gray-300">phpMyAdmin URL:</dt>
                            <dd class="text-gray-900 dark:text-white break-all">{{ $phpmyadminUrl }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ $phpmyadminUrl }}" target="_blank" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Open phpMyAdmin
                    </a>
                    @if(config('wphcp.adminer_enabled') && file_exists(config('wphcp.adminer_path')))
                        <a href="{{ asset('adminer.php?server=' . $database->host . ':' . $database->port . '&username=' . urlencode($database->username) . '&db=' . urlencode($database->name)) }}" target="_blank" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                            </svg>
                            Open Adminer
                        </a>
                    @endif
                    <a href="{{ route('sites.database', $site) }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 font-semibold transition-colors">
                        Use Built-in SQL Editor
                    </a>
                </div>

                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <strong>Note:</strong> Make sure phpMyAdmin is installed and accessible at the configured URL. 
                        If phpMyAdmin is not installed, you can use the built-in SQL editor or install Adminer (single-file alternative).
                    </p>
                </div>
            </div>

            <!-- Alternative: Adminer -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Alternative: Adminer</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Adminer is a lightweight, single-file database management tool. It's easier to set up than phpMyAdmin - just download one PHP file!
                </p>
                <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-800 dark:text-blue-200 mb-2">
                        <strong>Setup Instructions:</strong>
                    </p>
                    <ol class="list-decimal list-inside text-sm text-blue-700 dark:text-blue-300 space-y-1">
                        <li>Download Adminer from <a href="https://www.adminer.org/" target="_blank" class="underline font-medium">adminer.org</a></li>
                        <li>Place <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">adminer.php</code> in <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">public/</code> directory</li>
                        <li>Set <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">WPHCP_ADMINER_ENABLED=true</code> in <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">.env</code></li>
                    </ol>
                </div>
                <div class="flex gap-4">
                    <a href="https://www.adminer.org/" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                        Download Adminer →
                    </a>
                    <span class="text-gray-400">|</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Single PHP file (~500KB), no installation required
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

