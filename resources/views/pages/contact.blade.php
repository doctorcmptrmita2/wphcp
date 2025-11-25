<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - WPHCP</title>
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
                <h1 class="text-4xl font-bold text-gray-900 mb-6">Contact Us</h1>
                
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 mb-6">
                        We'd love to hear from you! Whether you have a question, need support, or want to provide feedback, 
                        we're here to help. Get in touch with us using the information below.
                    </p>

                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email
                            </h3>
                            <p class="text-gray-700">support@wphcp.io</p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Response Time
                            </h3>
                            <p class="text-gray-700">We typically respond within 24 hours</p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Support Channels</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li><strong>Technical Support:</strong> For technical issues, bugs, or feature requests</li>
                        <li><strong>General Inquiries:</strong> For questions about features, pricing, or partnerships</li>
                        <li><strong>Documentation:</strong> Check our documentation for common questions and guides</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Business Hours</h2>
                    <p class="text-gray-700 mb-4">
                        Our support team is available Monday through Friday, 9:00 AM - 6:00 PM (UTC).
                    </p>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <a href="{{ route('pages.about') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                        Learn More About Us
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>

