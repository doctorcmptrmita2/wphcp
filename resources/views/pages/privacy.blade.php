<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WPHCP Privacy Policy - Learn how we collect, use, and protect your personal information when using our WordPress Hosting Control Panel service.">
    <meta name="keywords" content="WPHCP privacy policy, data protection, privacy, GDPR, user privacy, data security">
    <meta name="author" content="WPHCP">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/privacy') }}">
    <meta property="og:title" content="Privacy Policy - WPHCP">
    <meta property="og:description" content="Learn how WPHCP collects, uses, and protects your personal information.">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/privacy') }}">
    <meta property="twitter:title" content="Privacy Policy - WPHCP">
    <meta property="twitter:description" content="Learn how WPHCP collects, uses, and protects your personal information.">
    
    <link rel="canonical" href="{{ url('/privacy') }}">
    <title>Privacy Policy - WPHCP</title>
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
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">Privacy Policy</h1>
                
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 mb-6 text-xs sm:text-sm text-gray-500">
                        Last updated: {{ date('F j, Y') }}
                    </p>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mt-6 sm:mt-8 mb-4">Introduction</h2>
                    <p class="text-gray-700 mb-6 text-base sm:text-lg">
                        WPHCP ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy explains 
                        how we collect, use, disclose, and safeguard your information when you use our WordPress Hosting 
                        Control Panel service.
                    </p>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mt-6 sm:mt-8 mb-4">Information We Collect</h2>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mt-4 sm:mt-6 mb-3">Personal Information</h3>
                    <p class="text-gray-700 mb-4 text-base sm:text-lg">
                        We may collect personal information that you provide to us, including:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6 text-base sm:text-lg">
                        <li>Name and contact information (email address, phone number)</li>
                        <li>Account credentials and authentication information</li>
                        <li>Billing and payment information</li>
                        <li>Site and domain information you manage through our platform</li>
                    </ul>

                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mt-4 sm:mt-6 mb-3">Technical Information</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6 text-base sm:text-lg">
                        <li>IP addresses and browser information</li>
                        <li>Usage data and analytics</li>
                        <li>Server logs and error reports</li>
                        <li>Database and site configuration data</li>
                    </ul>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mt-6 sm:mt-8 mb-4">How We Use Your Information</h2>
                    <p class="text-gray-700 mb-4 text-base sm:text-lg">We use the information we collect to:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6 text-base sm:text-lg">
                        <li>Provide, maintain, and improve our services</li>
                        <li>Process transactions and send related information</li>
                        <li>Send technical notices, updates, and support messages</li>
                        <li>Respond to your comments, questions, and requests</li>
                        <li>Monitor and analyze usage patterns and trends</li>
                        <li>Detect, prevent, and address technical issues and security threats</li>
                    </ul>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mt-6 sm:mt-8 mb-4">Data Security</h2>
                    <p class="text-gray-700 mb-6 text-base sm:text-lg">
                        We implement appropriate technical and organizational security measures to protect your personal information 
                        against unauthorized access, alteration, disclosure, or destruction. This includes encryption, secure 
                        authentication, and regular security audits.
                    </p>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mt-6 sm:mt-8 mb-4">Data Retention</h2>
                    <p class="text-gray-700 mb-6 text-base sm:text-lg">
                        We retain your personal information for as long as necessary to provide our services and fulfill the purposes 
                        outlined in this Privacy Policy, unless a longer retention period is required or permitted by law.
                    </p>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mt-6 sm:mt-8 mb-4">Your Rights</h2>
                    <p class="text-gray-700 mb-4 text-base sm:text-lg">You have the right to:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6 text-base sm:text-lg">
                        <li>Access and receive a copy of your personal information</li>
                        <li>Rectify inaccurate or incomplete information</li>
                        <li>Request deletion of your personal information</li>
                        <li>Object to processing of your personal information</li>
                        <li>Request restriction of processing</li>
                        <li>Data portability</li>
                    </ul>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mt-6 sm:mt-8 mb-4">Third-Party Services</h2>
                    <p class="text-gray-700 mb-6 text-base sm:text-lg">
                        Our service may contain links to third-party websites or services. We are not responsible for the privacy 
                        practices of these third parties. We encourage you to review their privacy policies.
                    </p>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mt-6 sm:mt-8 mb-4">Changes to This Privacy Policy</h2>
                    <p class="text-gray-700 mb-6 text-base sm:text-lg">
                        We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new 
                        Privacy Policy on this page and updating the "Last updated" date.
                    </p>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mt-6 sm:mt-8 mb-4">Contact Us</h2>
                    <p class="text-gray-700 mb-6 text-base sm:text-lg">
                        If you have any questions about this Privacy Policy, please contact us at:
                    </p>
                    <p class="text-gray-700 mb-6 text-base sm:text-lg">
                        <strong>Email:</strong> privacy@wphcp.io<br>
                        <strong>Address:</strong> [Your Company Address]
                    </p>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
