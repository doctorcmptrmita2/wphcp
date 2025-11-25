<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - WPHCP</title>
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

    <main class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg p-8 md:p-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-6">About WPHCP</h1>
                
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 mb-6">
                        WPHCP (WordPress Hosting Control Panel) is a modern, powerful platform designed to simplify WordPress site management. 
                        Built with Laravel 11 and cutting-edge technologies, WPHCP provides everything you need to manage multiple WordPress sites from a single, intuitive interface.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Our Mission</h2>
                    <p class="text-gray-700 mb-6">
                        Our mission is to make WordPress hosting management accessible, efficient, and secure for everyone. 
                        Whether you're managing a single site or hundreds of WordPress installations, WPHCP streamlines your workflow 
                        and eliminates the complexity of traditional hosting management.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">What We Offer</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li>Automated WordPress installation and configuration</li>
                        <li>Database management with integrated tools</li>
                        <li>DNS record management</li>
                        <li>SSL certificate automation with Let's Encrypt</li>
                        <li>Automated backup and restore functionality</li>
                        <li>Site maintenance mode controls</li>
                        <li>Secure API access for automation</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Technology Stack</h2>
                    <p class="text-gray-700 mb-4">
                        WPHCP is built on a robust technology foundation:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li><strong>Laravel 11</strong> - Modern PHP framework for rapid development</li>
                        <li><strong>MySQL</strong> - Reliable database management</li>
                        <li><strong>Tailwind CSS</strong> - Modern, responsive UI design</li>
                        <li><strong>Let's Encrypt</strong> - Free SSL certificate automation</li>
                        <li><strong>Nginx</strong> - High-performance web server integration</li>
                    </ul>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <a href="{{ route('pages.contact') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>

