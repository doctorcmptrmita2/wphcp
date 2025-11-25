<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WPHCP Product Roadmap - See what features and improvements are coming next. Q1 2025, Q2 2025, Q3 2025 plans and long-term goals.">
    <meta name="keywords" content="WPHCP roadmap, product roadmap, features, upcoming features, WordPress hosting roadmap">
    <meta name="author" content="WPHCP">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/roadmap') }}">
    <meta property="og:title" content="Product Roadmap - WPHCP">
    <meta property="og:description" content="See what features and improvements are coming to WPHCP in the near future.">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/roadmap') }}">
    <meta property="twitter:title" content="Product Roadmap - WPHCP">
    <meta property="twitter:description" content="See what features and improvements are coming to WPHCP in the near future.">
    
    <link rel="canonical" href="{{ url('/roadmap') }}">
    <title>Roadmap - WPHCP</title>
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
                <div class="flex items-center space-x-2 sm:space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-2 sm:px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-2 sm:px-3 py-2 rounded-md text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-3 sm:px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 md:p-12">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">Product Roadmap</h1>
                
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 mb-6 sm:mb-8 text-base sm:text-lg">
                        We're constantly working to improve WPHCP and add new features. Here's what's coming next:
                    </p>

                    <div class="space-y-6 sm:space-y-8">
                        <div class="border-l-4 border-indigo-500 pl-4 sm:pl-6">
                            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-2">Q1 2025 - Current Focus</h2>
                            <ul class="list-disc list-inside text-gray-700 space-y-2 text-base sm:text-lg">
                                <li>Enhanced backup scheduling and retention policies</li>
                                <li>Multi-server support and load balancing</li>
                                <li>Advanced monitoring and alerting system</li>
                                <li>Improved API documentation and SDKs</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-green-500 pl-4 sm:pl-6">
                            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-2">Q2 2025 - Planned Features</h2>
                            <ul class="list-disc list-inside text-gray-700 space-y-2 text-base sm:text-lg">
                                <li>WordPress plugin and theme management</li>
                                <li>Automated WordPress core updates</li>
                                <li>Staging environment creation</li>
                                <li>CDN integration and optimization</li>
                                <li>Advanced security scanning and malware detection</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-purple-500 pl-4 sm:pl-6">
                            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-2">Q3 2025 - Future Vision</h2>
                            <ul class="list-disc list-inside text-gray-700 space-y-2 text-base sm:text-lg">
                                <li>Multi-tenant support for hosting providers</li>
                                <li>White-label customization options</li>
                                <li>Advanced analytics and reporting</li>
                                <li>Mobile app for iOS and Android</li>
                                <li>Integration with popular hosting providers</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-orange-500 pl-4 sm:pl-6">
                            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-2">Long-term Goals</h2>
                            <ul class="list-disc list-inside text-gray-700 space-y-2 text-base sm:text-lg">
                                <li>AI-powered site optimization recommendations</li>
                                <li>Automated performance tuning</li>
                                <li>Advanced disaster recovery solutions</li>
                                <li>Enterprise-grade compliance features</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-8 p-4 sm:p-6 bg-indigo-50 rounded-lg">
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Have a Feature Request?</h3>
                        <p class="text-gray-700 mb-4 text-base sm:text-lg">
                            We value your feedback! If you have ideas for features you'd like to see, 
                            please don't hesitate to reach out.
                        </p>
                        <a href="{{ route('pages.contact') }}" class="inline-block bg-indigo-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-sm sm:text-base font-semibold hover:bg-indigo-700 transition-colors">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
