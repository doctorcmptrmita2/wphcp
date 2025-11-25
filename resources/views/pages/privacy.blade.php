<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <h1 class="text-4xl font-bold text-gray-900 mb-6">Privacy Policy</h1>
                
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 mb-6 text-sm text-gray-500">
                        Last updated: {{ date('F j, Y') }}
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Introduction</h2>
                    <p class="text-gray-700 mb-6">
                        WPHCP ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy explains 
                        how we collect, use, disclose, and safeguard your information when you use our WordPress Hosting 
                        Control Panel service.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Information We Collect</h2>
                    <h3 class="text-xl font-semibold text-gray-900 mt-6 mb-3">Personal Information</h3>
                    <p class="text-gray-700 mb-4">
                        We may collect personal information that you provide to us, including:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li>Name and contact information (email address, phone number)</li>
                        <li>Account credentials and authentication information</li>
                        <li>Billing and payment information</li>
                        <li>Site and domain information you manage through our platform</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-900 mt-6 mb-3">Technical Information</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li>IP addresses and browser information</li>
                        <li>Usage data and analytics</li>
                        <li>Server logs and error reports</li>
                        <li>Database and site configuration data</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">How We Use Your Information</h2>
                    <p class="text-gray-700 mb-4">We use the information we collect to:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li>Provide, maintain, and improve our services</li>
                        <li>Process transactions and send related information</li>
                        <li>Send technical notices, updates, and support messages</li>
                        <li>Respond to your comments, questions, and requests</li>
                        <li>Monitor and analyze usage patterns and trends</li>
                        <li>Detect, prevent, and address technical issues and security threats</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Data Security</h2>
                    <p class="text-gray-700 mb-6">
                        We implement appropriate technical and organizational security measures to protect your personal information 
                        against unauthorized access, alteration, disclosure, or destruction. This includes encryption, secure 
                        authentication, and regular security audits.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Data Retention</h2>
                    <p class="text-gray-700 mb-6">
                        We retain your personal information for as long as necessary to provide our services and fulfill the purposes 
                        outlined in this Privacy Policy, unless a longer retention period is required or permitted by law.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Your Rights</h2>
                    <p class="text-gray-700 mb-4">You have the right to:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li>Access and receive a copy of your personal information</li>
                        <li>Rectify inaccurate or incomplete information</li>
                        <li>Request deletion of your personal information</li>
                        <li>Object to processing of your personal information</li>
                        <li>Request restriction of processing</li>
                        <li>Data portability</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Third-Party Services</h2>
                    <p class="text-gray-700 mb-6">
                        Our service may contain links to third-party websites or services. We are not responsible for the privacy 
                        practices of these third parties. We encourage you to review their privacy policies.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Changes to This Privacy Policy</h2>
                    <p class="text-gray-700 mb-6">
                        We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new 
                        Privacy Policy on this page and updating the "Last updated" date.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Contact Us</h2>
                    <p class="text-gray-700 mb-6">
                        If you have any questions about this Privacy Policy, please contact us at:
                    </p>
                    <p class="text-gray-700 mb-6">
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

