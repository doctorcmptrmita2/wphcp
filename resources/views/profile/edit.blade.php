<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profile') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your account settings and preferences</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                    <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Information</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update your account's profile information and email address.</p>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                    <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Password</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ensure your account is using a strong, unique password.</p>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl border border-red-200 dark:border-red-900">
                <div class="max-w-xl">
                    <div class="mb-6 pb-4 border-b border-red-200 dark:border-red-800">
                        <h3 class="text-lg font-semibold text-red-900 dark:text-red-200">Delete Account</h3>
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
