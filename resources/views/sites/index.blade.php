@extends('layouts.app')

@section('title', 'Sites - WPHCP')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Sites</h1>
    <a href="{{ route('sites.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Create New Site
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PHP Version</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Backup</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($sites as $site)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('sites.show', $site) }}" class="text-blue-600 hover:underline">
                            {{ $site->domain }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $site->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $site->status === 'error' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $site->status === 'creating' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $site->status === 'disabled' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ $site->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $site->php_version }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $site->last_backup_at ? $site->last_backup_at->format('Y-m-d H:i') : 'Never' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('sites.show', $site) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        No sites found. <a href="{{ route('sites.create') }}" class="text-blue-600 hover:underline">Create one</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

