<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $site->domain }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Status: 
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $site->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                           ($site->status === 'creating' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                           'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                        {{ $site->status }}
                    </span>
                </p>
            </div>
            <a href="{{ route('sites.index') }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Sites
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Management Tabs -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <span class="px-6 py-4 text-sm font-medium border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 cursor-default">
                            Overview
                        </span>
                        @if($site->database)
                            <a href="{{ route('sites.database', $site) }}" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                                Database
                            </a>
                        @endif
                        <a href="{{ route('sites.dns', $site) }}" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                            DNS
                        </a>
                        <a href="{{ route('sites.settings', $site) }}" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                            Settings
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Site Information Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Site Information
                    </h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Domain</dt>
                            <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $site->domain }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Root Path</dt>
                            <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1 font-mono text-sm">{{ $site->root_path }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">PHP Version</dt>
                            <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $site->php_version }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Backup</dt>
                            <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                                {{ $site->last_backup_at ? $site->last_backup_at->format('Y-m-d H:i') : 'Never' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                        </svg>
                        Database Information
                    </h3>
                    @if($site->database)
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Database Name</dt>
                                <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1 font-mono text-sm">{{ $site->database->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Username</dt>
                                <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1 font-mono text-sm">{{ $site->database->username }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Host</dt>
                                <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $site->database->host }}:{{ $site->database->port }}</dd>
                            </div>
                            @if($site->database->size_mb)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Size</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ number_format($site->database->size_mb, 2) }} MB</dd>
                                </div>
                            @endif
                            <div class="pt-2">
                                <a href="{{ route('sites.database', $site) }}" class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Manage Database
                                </a>
                            </div>
                        </dl>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No database associated</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <form method="POST" action="{{ route('sites.backup', $site) }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 font-medium transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            Create Backup
                        </button>
                    </form>

                    <form method="POST" action="{{ route('sites.maintenance-toggle', $site) }}" class="inline">
                        @csrf
                        <input type="hidden" name="enabled" value="{{ $site->maintenance_mode ? '0' : '1' }}">
                        <button type="submit" class="bg-yellow-600 text-white px-4 py-3 rounded-lg hover:bg-yellow-700 font-medium transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            {{ $site->maintenance_mode ? 'Disable' : 'Enable' }} Maintenance Mode
                        </button>
                    </form>

                    <form method="POST" action="{{ route('sites.reset-password', $site) }}" class="inline" onsubmit="return confirm('Are you sure you want to reset the admin password?')">
                        @csrf
                        <div class="flex gap-2">
                            <input type="password" name="new_password" placeholder="New password" required minlength="8"
                                class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                            <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 font-medium transition-colors">
                                Reset Admin Password
                            </button>
                        </div>
                    </form>

                    @if(!$site->sslCertificate || $site->sslCertificate->status !== 'active')
                        <form method="POST" action="{{ route('sites.ssl-request', $site) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 font-medium transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Request SSL Certificate
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- SSL Certificate -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">SSL Certificate</h3>
                @if($site->sslCertificate)
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $site->sslCertificate->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $site->sslCertificate->status }}
                                </span>
                            </dd>
                        </div>
                        @if($site->sslCertificate->expires_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Expires At</dt>
                                <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $site->sslCertificate->expires_at->format('Y-m-d H:i') }}</dd>
                            </div>
                        @endif
                        @if($site->sslCertificate->last_renewed_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Renewed</dt>
                                <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $site->sslCertificate->last_renewed_at->format('Y-m-d H:i') }}</dd>
                            </div>
                        @endif
                    </dl>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No SSL certificate configured</p>
                @endif
            </div>

            <!-- Backups -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Backups</h3>
                @if($site->backups->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Size</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($site->backups as $backup)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $backup->type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $backup->status === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                {{ $backup->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $backup->size_mb ? number_format($backup->size_mb, 2) . ' MB' : 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $backup->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No backups yet</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
