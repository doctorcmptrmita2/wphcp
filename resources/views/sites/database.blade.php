<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Database Management - {{ $site->domain }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your database: {{ $database->name }}</p>
            </div>
            <a href="{{ route('sites.show', $site) }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Site
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Management Tabs -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <a href="{{ route('sites.show', $site) }}" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                            Overview
                        </a>
                        <a href="{{ route('sites.database', $site) }}" class="px-6 py-4 text-sm font-medium border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400">
                            Database
                        </a>
                        <a href="{{ route('sites.dns', $site) }}" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                            DNS
                        </a>
                        <a href="{{ route('sites.settings', $site) }}" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                            Settings
                        </a>
                    </nav>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Database Info -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Database Information</h3>
                    <a href="{{ route('sites.database.phpmyadmin', $site) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium text-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                        </svg>
                        phpMyAdmin
                    </a>
                </div>
                <dl class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Database Name</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1 font-mono text-sm">{{ $database->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Username</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1 font-mono text-sm">{{ $database->username }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Host</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $database->host }}:{{ $database->port }}</dd>
                    </div>
                    @if($database->size_mb)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Size</dt>
                            <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ number_format($database->size_mb, 2) }} MB</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- SQL Query Interface -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">SQL Query</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Only SELECT queries are allowed for security reasons.</p>
                <form method="POST" action="{{ route('sites.database.query', $site) }}">
                    @csrf
                    <div class="mb-4">
                        <textarea name="query" id="query" rows="6" required placeholder="SELECT * FROM wp_posts LIMIT 10;" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white font-mono text-sm focus:ring-2 focus:ring-indigo-500">{{ session('query_executed') }}</textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-medium transition-colors">
                        Execute Query
                    </button>
                </form>

                @if(session('query_results'))
                    <div class="mt-6">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-2">Query Results</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        @if(count(session('query_results')) > 0)
                                            @foreach(array_keys((array) session('query_results')[0]) as $column)
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">{{ $column }}</th>
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach(session('query_results') as $row)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            @foreach((array) $row as $value)
                                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $value ?? 'NULL' }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tables List -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Database Tables</h3>
                        <a href="{{ route('sites.database.tables', $site) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium">
                            Refresh
                        </a>
                    </div>
                    @if(isset($tables) && count($tables) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach($tables as $table)
                                <a href="{{ route('sites.database.table', [$site, $table]) }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                    <div class="font-mono text-sm text-gray-900 dark:text-white">{{ $table }}</div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No tables found or unable to fetch tables.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

