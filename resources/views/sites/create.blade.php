<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Create New Site') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Set up a new WordPress site</p>
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <form method="POST" action="{{ route('sites.store') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="domain" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Domain</label>
                            <input type="text" name="domain" id="domain" value="{{ old('domain') }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                placeholder="example.com">
                            @error('domain')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="site_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Site Title</label>
                            <input type="text" name="site_title" id="site_title" value="{{ old('site_title') }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                placeholder="My WordPress Site">
                            @error('site_title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="admin_username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Admin Username</label>
                            <input type="text" name="admin_username" id="admin_username" value="{{ old('admin_username') }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                placeholder="admin">
                            @error('admin_username')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="admin_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Admin Email</label>
                            <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                placeholder="admin@example.com">
                            @error('admin_email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="admin_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Admin Password</label>
                            <input type="password" name="admin_password" id="admin_password" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                placeholder="Minimum 8 characters">
                            @error('admin_password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="php_version" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">PHP Version <span class="text-gray-400 font-normal">(optional)</span></label>
                            <input type="text" name="php_version" id="php_version" value="{{ old('php_version', config('wphcp.default_php_version')) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                placeholder="8.2">
                            @error('php_version')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-8 py-3 rounded-lg hover:from-indigo-700 hover:to-indigo-800 font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Site
                            </button>
                            <a href="{{ route('sites.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-8 py-3 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 font-semibold transition-all duration-200 flex items-center gap-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
