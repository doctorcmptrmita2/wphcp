<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Who We Are - WPHCP</title>
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
                <h1 class="text-4xl font-bold text-gray-900 mb-6">Who We Are</h1>
                
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 mb-6">
                        WPHCP is developed by a team of passionate developers and system administrators who understand the challenges 
                        of managing multiple WordPress installations. We've experienced firsthand the time-consuming tasks of manual 
                        site provisioning, SSL management, and database administration.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Our Story</h2>
                    <p class="text-gray-700 mb-6">
                        Born from the need for a better WordPress hosting management solution, WPHCP was created to address the pain points 
                        that hosting providers and developers face daily. We believe that managing WordPress sites should be simple, 
                        automated, and secure—without compromising on functionality or performance.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Our Values</h2>
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Simplicity</h3>
                            <p class="text-gray-700">We believe in making complex tasks simple and intuitive.</p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Security</h3>
                            <p class="text-gray-700">Security is at the core of everything we build.</p>
                        </div>
                        <div class="bg-purple-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Innovation</h3>
                            <p class="text-gray-700">We continuously improve and innovate our platform.</p>
                        </div>
                        <div class="bg-orange-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Reliability</h3>
                            <p class="text-gray-700">We build systems you can depend on, day in and day out.</p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Our Commitment</h2>
                    <p class="text-gray-700 mb-6">
                        We are committed to providing a platform that grows with your needs. Whether you're managing a handful of sites 
                        or scaling to hundreds, WPHCP is designed to be your reliable partner in WordPress hosting management.
                    </p>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <a href="{{ route('pages.contact') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                        Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>

