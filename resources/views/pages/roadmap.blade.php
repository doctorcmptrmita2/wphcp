<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <h1 class="text-4xl font-bold text-gray-900 mb-6">Product Roadmap</h1>
                
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 mb-8">
                        We're constantly working to improve WPHCP and add new features. Here's what's coming next:
                    </p>

                    <div class="space-y-8">
                        <div class="border-l-4 border-indigo-500 pl-6">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Q1 2025 - Current Focus</h2>
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <li>Enhanced backup scheduling and retention policies</li>
                                <li>Multi-server support and load balancing</li>
                                <li>Advanced monitoring and alerting system</li>
                                <li>Improved API documentation and SDKs</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-green-500 pl-6">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Q2 2025 - Planned Features</h2>
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <li>WordPress plugin and theme management</li>
                                <li>Automated WordPress core updates</li>
                                <li>Staging environment creation</li>
                                <li>CDN integration and optimization</li>
                                <li>Advanced security scanning and malware detection</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-purple-500 pl-6">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Q3 2025 - Future Vision</h2>
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <li>Multi-tenant support for hosting providers</li>
                                <li>White-label customization options</li>
                                <li>Advanced analytics and reporting</li>
                                <li>Mobile app for iOS and Android</li>
                                <li>Integration with popular hosting providers</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-orange-500 pl-6">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Long-term Goals</h2>
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <li>AI-powered site optimization recommendations</li>
                                <li>Automated performance tuning</li>
                                <li>Advanced disaster recovery solutions</li>
                                <li>Enterprise-grade compliance features</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 p-6 bg-indigo-50 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Have a Feature Request?</h3>
                        <p class="text-gray-700 mb-4">
                            We value your feedback! If you have ideas for features you'd like to see, 
                            please don't hesitate to reach out.
                        </p>
                        <a href="{{ route('pages.contact') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
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

