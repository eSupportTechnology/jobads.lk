<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div>
                <a href="{{ route('profile.edit') }}"
                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    {{ __('Edit Profile') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Welcome') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __("You're logged in! Here's an overview of your account.") }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Recent Activity') }}
                    </h3>
                    <!-- Add your recent activity content here -->
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('No recent activity.') }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Quick Actions') }}
                    </h3>
                    <div class="space-y-2">
                        <a href="#" class="block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            {{ __('Create New Project') }}
                        </a>
                        <a href="#" class="block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            {{ __('View Reports') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
