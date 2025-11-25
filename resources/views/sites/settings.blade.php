<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Settings - {{ $site->domain }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage site settings and configuration</p>
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
                        @if($site->database)
                            <a href="{{ route('sites.database', $site) }}" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                                Database
                            </a>
                        @endif
                        <a href="{{ route('sites.dns', $site) }}" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                            DNS
                        </a>
                        <a href="{{ route('sites.settings', $site) }}" class="px-6 py-4 text-sm font-medium border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400">
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

            <!-- General Settings -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">General Settings</h3>
                <form method="POST" action="{{ route('sites.settings.update', $site) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <label for="php_version" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">PHP Version</label>
                            <select name="php_version" id="php_version" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                <option value="8.2" {{ $site->php_version === '8.2' ? 'selected' : '' }}>8.2</option>
                                <option value="8.1" {{ $site->php_version === '8.1' ? 'selected' : '' }}>8.1</option>
                                <option value="8.0" {{ $site->php_version === '8.0' ? 'selected' : '' }}>8.0</option>
                                <option value="7.4" {{ $site->php_version === '7.4' ? 'selected' : '' }}>7.4</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select the PHP version for this site</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1" {{ $site->maintenance_mode ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="maintenance_mode" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Enable Maintenance Mode
                            </label>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold transition-colors">
                                Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Site Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Site Information</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Domain</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $site->domain }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Root Path</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1 font-mono text-sm">{{ $site->root_path }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $site->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                   ($site->status === 'creating' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                   'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                {{ $site->status }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $site->created_at->format('Y-m-d H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Database Information -->
            @if($site->database)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Database Information</h3>
                        <a href="{{ route('sites.database', $site) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium">
                            Manage Database →
                        </a>
                    </div>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    </dl>
                </div>
            @endif

            <!-- DNS Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">DNS Records</h3>
                    <a href="{{ route('sites.dns', $site) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium">
                        Manage DNS →
                    </a>
                </div>
                @if($site->dnsRecords->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Value</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($site->dnsRecords->take(5) as $record)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                {{ $record->type }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white font-mono">{{ $record->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white font-mono">{{ $record->value }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $record->active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ $record->active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($site->dnsRecords->count() > 5)
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Showing 5 of {{ $site->dnsRecords->count() }} records. <a href="{{ route('sites.dns', $site) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">View all</a></p>
                    @endif
                @else
                    <p class="text-gray-500 dark:text-gray-400">No DNS records found.</p>
                @endif
            </div>

            <!-- SSL Certificate -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
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
                    </dl>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No SSL certificate configured.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

