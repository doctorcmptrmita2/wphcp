@extends('layouts.app')

@section('title', 'Create Site - WPHCP')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Create New Site</h1>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('sites.store') }}">
        @csrf

        <div class="mb-4">
            <label for="domain" class="block text-sm font-medium text-gray-700 mb-2">Domain</label>
            <input type="text" name="domain" id="domain" value="{{ old('domain') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="example.com">
            @error('domain')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="site_title" class="block text-sm font-medium text-gray-700 mb-2">Site Title</label>
            <input type="text" name="site_title" id="site_title" value="{{ old('site_title') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="My WordPress Site">
            @error('site_title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="admin_username" class="block text-sm font-medium text-gray-700 mb-2">Admin Username</label>
            <input type="text" name="admin_username" id="admin_username" value="{{ old('admin_username') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="admin">
            @error('admin_username')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-2">Admin Email</label>
            <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="admin@example.com">
            @error('admin_email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="admin_password" class="block text-sm font-medium text-gray-700 mb-2">Admin Password</label>
            <input type="password" name="admin_password" id="admin_password" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Minimum 8 characters">
            @error('admin_password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="php_version" class="block text-sm font-medium text-gray-700 mb-2">PHP Version (optional)</label>
            <input type="text" name="php_version" id="php_version" value="{{ old('php_version', config('wphcp.default_php_version')) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="8.2">
            @error('php_version')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Create Site
            </button>
            <a href="{{ route('sites.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

