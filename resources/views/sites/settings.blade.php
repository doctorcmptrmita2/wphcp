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
                    </dl>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No SSL certificate configured.</p>
                @endif
            </div>

            <!-- EasyPanel Deploy Settings -->
            @if(config('wphcp.easypanel.enabled'))
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">EasyPanel Deploy</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure EasyPanel deployment settings for this site</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                            EasyPanel
                        </span>
                    </div>

                    <form method="POST" action="{{ route('sites.settings.update', $site) }}" id="easypanel-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Enable EasyPanel -->
                            <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <input 
                                    type="checkbox" 
                                    name="easypanel_enabled" 
                                    id="easypanel_enabled" 
                                    value="1" 
                                    {{ $site->easypanel_enabled ? 'checked' : '' }} 
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                    onchange="toggleEasyPanelFields()">
                                <label for="easypanel_enabled" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Enable EasyPanel Deployment
                                </label>
                            </div>

                            <div id="easypanel-fields" class="{{ $site->easypanel_enabled ? '' : 'hidden' }} space-y-6">
                                <!-- Project & Service Names -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="easypanel_project_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Project Name
                                        </label>
                                        <input 
                                            type="text" 
                                            name="easypanel_project_name" 
                                            id="easypanel_project_name" 
                                            value="{{ old('easypanel_project_name', $site->easypanel_project_name) }}"
                                            placeholder="my-project"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">EasyPanel project name</p>
                                    </div>
                                    <div>
                                        <label for="easypanel_service_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Service Name
                                        </label>
                                        <input 
                                            type="text" 
                                            name="easypanel_service_name" 
                                            id="easypanel_service_name" 
                                            value="{{ old('easypanel_service_name', $site->easypanel_service_name) }}"
                                            placeholder="my-service"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Service name in EasyPanel</p>
                                    </div>
                                </div>

                                <!-- Deploy Method -->
                                <div>
                                    <label for="easypanel_deploy_method" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Deploy Method
                                    </label>
                                    <select 
                                        name="easypanel_deploy_method" 
                                        id="easypanel_deploy_method" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500"
                                        onchange="toggleDeployMethodFields()">
                                        <option value="">Select method...</option>
                                        <option value="git" {{ $site->easypanel_deploy_method === 'git' ? 'selected' : '' }}>Git Repository</option>
                                        <option value="docker_image" {{ $site->easypanel_deploy_method === 'docker_image' ? 'selected' : '' }}>Docker Image</option>
                                        <option value="docker_compose" {{ $site->easypanel_deploy_method === 'docker_compose' ? 'selected' : '' }}>Docker Compose</option>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Choose how to deploy this service</p>
                                </div>

                                <!-- Git Repository Fields -->
                                <div id="git-fields" class="{{ $site->easypanel_deploy_method === 'git' ? '' : 'hidden' }} space-y-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Git Repository Settings</h4>
                                    <div>
                                        <label for="easypanel_repository_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Repository URL
                                        </label>
                                        <input 
                                            type="url" 
                                            name="easypanel_repository_url" 
                                            id="easypanel_repository_url" 
                                            value="{{ old('easypanel_repository_url', $site->easypanel_repository_url) }}"
                                            placeholder="https://github.com/user/repo.git"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="easypanel_branch" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Branch
                                        </label>
                                        <input 
                                            type="text" 
                                            name="easypanel_branch" 
                                            id="easypanel_branch" 
                                            value="{{ old('easypanel_branch', $site->easypanel_branch ?? 'main') }}"
                                            placeholder="main"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                </div>

                                <!-- Docker Image Fields -->
                                <div id="docker-image-fields" class="{{ $site->easypanel_deploy_method === 'docker_image' ? '' : 'hidden' }} space-y-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Docker Image Settings</h4>
                                    <div>
                                        <label for="easypanel_docker_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Docker Image
                                        </label>
                                        <input 
                                            type="text" 
                                            name="easypanel_docker_image" 
                                            id="easypanel_docker_image" 
                                            value="{{ old('easypanel_docker_image', $site->easypanel_docker_image) }}"
                                            placeholder="nginx:latest"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                </div>

                                <!-- Port & Resources -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label for="easypanel_port" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Port
                                        </label>
                                        <input 
                                            type="number" 
                                            name="easypanel_port" 
                                            id="easypanel_port" 
                                            value="{{ old('easypanel_port', $site->easypanel_port) }}"
                                            placeholder="3000"
                                            min="1"
                                            max="65535"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="easypanel_cpu_limit" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            CPU Limit
                                        </label>
                                        <input 
                                            type="text" 
                                            name="easypanel_cpu_limit" 
                                            id="easypanel_cpu_limit" 
                                            value="{{ old('easypanel_cpu_limit', $site->easypanel_cpu_limit) }}"
                                            placeholder="0.5"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">e.g., 0.5, 1, 2</p>
                                    </div>
                                    <div>
                                        <label for="easypanel_memory_limit" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Memory Limit
                                        </label>
                                        <input 
                                            type="text" 
                                            name="easypanel_memory_limit" 
                                            id="easypanel_memory_limit" 
                                            value="{{ old('easypanel_memory_limit', $site->easypanel_memory_limit) }}"
                                            placeholder="512M"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">e.g., 512M, 1G</p>
                                    </div>
                                </div>

                                <!-- Environment Variables -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Environment Variables
                                    </label>
                                    <div id="env-vars-container" class="space-y-3">
                                        @if($site->easypanel_env_vars && is_array($site->easypanel_env_vars))
                                            @foreach($site->easypanel_env_vars as $key => $value)
                                                <div class="flex gap-3 env-var-row">
                                                    <input 
                                                        type="text" 
                                                        name="easypanel_env_vars[{{ $loop->index }}][key]" 
                                                        value="{{ $key }}"
                                                        placeholder="KEY"
                                                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                                    <input 
                                                        type="text" 
                                                        name="easypanel_env_vars[{{ $loop->index }}][value]" 
                                                        value="{{ $value }}"
                                                        placeholder="VALUE"
                                                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                                    <button 
                                                        type="button" 
                                                        onclick="removeEnvVar(this)"
                                                        class="px-3 py-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button 
                                        type="button" 
                                        onclick="addEnvVar()"
                                        class="mt-3 px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 border border-indigo-300 dark:border-indigo-600 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                        + Add Environment Variable
                                    </button>
                                </div>

                                <!-- Save Button -->
                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 font-semibold transition-all duration-200 shadow-lg hover:shadow-xl">
                                        Save EasyPanel Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script>
        let envVarIndex = {{ $site->easypanel_env_vars && is_array($site->easypanel_env_vars) ? count($site->easypanel_env_vars) : 0 }};

        function toggleEasyPanelFields() {
            const checkbox = document.getElementById('easypanel_enabled');
            const fields = document.getElementById('easypanel-fields');
            if (checkbox.checked) {
                fields.classList.remove('hidden');
            } else {
                fields.classList.add('hidden');
            }
        }

        function toggleDeployMethodFields() {
            const method = document.getElementById('easypanel_deploy_method').value;
            const gitFields = document.getElementById('git-fields');
            const dockerImageFields = document.getElementById('docker-image-fields');

            // Hide all fields
            if (gitFields) gitFields.classList.add('hidden');
            if (dockerImageFields) dockerImageFields.classList.add('hidden');

            // Show relevant fields
            if (method === 'git' && gitFields) {
                gitFields.classList.remove('hidden');
            } else if (method === 'docker_image' && dockerImageFields) {
                dockerImageFields.classList.remove('hidden');
            }
        }

        function addEnvVar() {
            const container = document.getElementById('env-vars-container');
            const row = document.createElement('div');
            row.className = 'flex gap-3 env-var-row';
            row.innerHTML = `
                <input 
                    type="text" 
                    name="easypanel_env_vars[${envVarIndex}][key]" 
                    placeholder="KEY"
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                <input 
                    type="text" 
                    name="easypanel_env_vars[${envVarIndex}][value]" 
                    placeholder="VALUE"
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                <button 
                    type="button" 
                    onclick="removeEnvVar(this)"
                    class="px-3 py-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            container.appendChild(row);
            envVarIndex++;
        }

        function removeEnvVar(button) {
            button.closest('.env-var-row').remove();
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleDeployMethodFields();
        });
    </script>
</x-app-layout>

