<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WPHCP - WordPress Hosting Control Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center hover:opacity-80 transition-opacity">
                        <x-wphcp-logo class="h-10 sm:h-12" :showText="true" size="large" />
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
                </nav>

    <main>
        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-5xl font-extrabold text-gray-900 sm:text-6xl">
                    WordPress Hosting
                    <span class="text-indigo-600">Control Panel</span>
                </h1>
                <p class="mt-6 text-xl text-gray-600 max-w-3xl mx-auto">
                    Manage your WordPress sites with ease. Create, backup, and manage SSL certificates all from one simple interface.
                </p>
                <div class="mt-10 flex justify-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-indigo-700 shadow-lg">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-indigo-700 shadow-lg">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-50 shadow-lg border-2 border-indigo-600">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-gray-900">Powerful Features</h2>
                    <p class="mt-4 text-lg text-gray-600">Everything you need to manage WordPress sites</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-xl shadow-lg">
                        <div class="text-indigo-600 text-4xl mb-4">🚀</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Quick Site Creation</h3>
                        <p class="text-gray-600">Create WordPress sites in minutes with automated installation and configuration.</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-xl shadow-lg">
                        <div class="text-green-600 text-4xl mb-4">💾</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Automated Backups</h3>
                        <p class="text-gray-600">Schedule automatic backups and restore your sites with a single click.</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-xl shadow-lg">
                        <div class="text-purple-600 text-4xl mb-4">🔒</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">SSL Management</h3>
                        <p class="text-gray-600">Automatically manage Let's Encrypt SSL certificates for all your domains.</p>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 p-8 rounded-xl shadow-lg">
                        <div class="text-orange-600 text-4xl mb-4">🗄️</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Database Management</h3>
                        <p class="text-gray-600">Create and manage MySQL databases for each WordPress site automatically.</p>
                    </div>
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-8 rounded-xl shadow-lg">
                        <div class="text-teal-600 text-4xl mb-4">⚡</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Fast & Reliable</h3>
                        <p class="text-gray-600">Built on Laravel 11 with modern architecture for maximum performance.</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-rose-50 p-8 rounded-xl shadow-lg">
                        <div class="text-red-600 text-4xl mb-4">🛠️</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Easy Maintenance</h3>
                        <p class="text-gray-600">Toggle maintenance mode, reset passwords, and manage sites effortlessly.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-indigo-600 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-white mb-4">Ready to get started?</h2>
                <p class="text-xl text-indigo-100 mb-8">Start managing your WordPress sites today</p>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 shadow-lg">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 shadow-lg">
                        Create Account
                    </a>
                @endauth
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} WPHCP. All rights reserved.</p>
        </div>
    </footer>
    </body>
</html>
