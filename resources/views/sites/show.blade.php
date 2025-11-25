@extends('layouts.app')

@section('title', $site->domain . ' - WPHCP')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $site->domain }}</h1>
            <p class="text-gray-500 mt-1">
                Status: <span class="font-medium {{ $site->status === 'active' ? 'text-green-600' : 'text-red-600' }}">{{ $site->status }}</span>
            </p>
        </div>
        <a href="{{ route('sites.index') }}" class="text-gray-600 hover:text-gray-800">← Back to Sites</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Site Information</h2>
        <dl class="space-y-2">
            <div>
                <dt class="text-sm text-gray-500">Domain</dt>
                <dd class="text-lg font-medium">{{ $site->domain }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Root Path</dt>
                <dd class="text-lg font-medium">{{ $site->root_path }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">PHP Version</dt>
                <dd class="text-lg font-medium">{{ $site->php_version }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Last Backup</dt>
                <dd class="text-lg font-medium">{{ $site->last_backup_at ? $site->last_backup_at->format('Y-m-d H:i') : 'Never' }}</dd>
            </div>
        </dl>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Database Information</h2>
        @if($site->database)
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm text-gray-500">Database Name</dt>
                    <dd class="text-lg font-medium">{{ $site->database->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Username</dt>
                    <dd class="text-lg font-medium">{{ $site->database->username }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Host</dt>
                    <dd class="text-lg font-medium">{{ $site->database->host }}:{{ $site->database->port }}</dd>
                </div>
                @if($site->database->size_mb)
                    <div>
                        <dt class="text-sm text-gray-500">Size</dt>
                        <dd class="text-lg font-medium">{{ $site->database->size_mb }} MB</dd>
                    </div>
                @endif
            </dl>
        @else
            <p class="text-gray-500">No database associated</p>
        @endif
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
    <div class="flex flex-wrap gap-4">
        <form method="POST" action="{{ route('sites.backup', $site) }}" class="inline">
            @csrf
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create Backup
            </button>
        </form>

        <form method="POST" action="{{ route('sites.maintenance-toggle', $site) }}" class="inline">
            @csrf
            <input type="hidden" name="enabled" value="{{ $site->maintenance_mode ? '0' : '1' }}">
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                {{ $site->maintenance_mode ? 'Disable' : 'Enable' }} Maintenance Mode
            </button>
        </form>

        <form method="POST" action="{{ route('sites.reset-password', $site) }}" class="inline" onsubmit="return confirm('Are you sure you want to reset the admin password?')">
            @csrf
            <input type="password" name="new_password" placeholder="New password" required minlength="8"
                class="px-3 py-2 border border-gray-300 rounded mr-2">
            <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
                Reset Admin Password
            </button>
        </form>

        @if(!$site->sslCertificate || $site->sslCertificate->status !== 'active')
            <form method="POST" action="{{ route('sites.ssl-request', $site) }}" class="inline">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Request SSL Certificate
                </button>
            </form>
        @endif
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">SSL Certificate</h2>
    @if($site->sslCertificate)
        <dl class="space-y-2">
            <div>
                <dt class="text-sm text-gray-500">Status</dt>
                <dd class="text-lg font-medium">
                    <span class="px-2 py-1 text-xs rounded
                        {{ $site->sslCertificate->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $site->sslCertificate->status }}
                    </span>
                </dd>
            </div>
            @if($site->sslCertificate->expires_at)
                <div>
                    <dt class="text-sm text-gray-500">Expires At</dt>
                    <dd class="text-lg font-medium">{{ $site->sslCertificate->expires_at->format('Y-m-d H:i') }}</dd>
                </div>
            @endif
            @if($site->sslCertificate->last_renewed_at)
                <div>
                    <dt class="text-sm text-gray-500">Last Renewed</dt>
                    <dd class="text-lg font-medium">{{ $site->sslCertificate->last_renewed_at->format('Y-m-d H:i') }}</dd>
                </div>
            @endif
        </dl>
    @else
        <p class="text-gray-500">No SSL certificate configured</p>
    @endif
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Backups</h2>
    @if($site->backups->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Size</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($site->backups as $backup)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $backup->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded
                                {{ $backup->status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $backup->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $backup->size_mb ? $backup->size_mb . ' MB' : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $backup->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500">No backups yet</p>
    @endif
</div>
@endsection

