@props(['class' => 'h-10 w-auto', 'showText' => true, 'size' => 'default', 'textColor' => 'default'])

@php
    $textSize = $size === 'large' ? 'text-2xl' : 'text-xl';
    $subtextSize = $size === 'large' ? 'text-sm' : 'text-xs';
    $textColorClass = $textColor === 'white' ? 'text-white' : 'text-gray-900 dark:text-white';
    $subtextColorClass = $textColor === 'white' ? 'text-gray-300' : 'text-gray-500 dark:text-gray-400';
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <!-- Logo Icon -->
    <div class="relative flex-shrink-0">
        <svg class="{{ $class }}" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="wphcp-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#6366f1;stop-opacity:1" />
                    <stop offset="50%" style="stop-color:#5b21b6;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#4f46e5;stop-opacity:1" />
                </linearGradient>
                <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                    <feGaussianBlur in="SourceAlpha" stdDeviation="2"/>
                    <feOffset dx="0" dy="2" result="offsetblur"/>
                    <feComponentTransfer>
                        <feFuncA type="linear" slope="0.3"/>
                    </feComponentTransfer>
                    <feMerge>
                        <feMergeNode/>
                        <feMergeNode in="SourceGraphic"/>
                    </feMerge>
                </filter>
            </defs>
            
            <!-- Background Circle with Gradient -->
            <circle cx="32" cy="32" r="30" fill="url(#wphcp-gradient)" filter="url(#shadow)"/>
            <circle cx="32" cy="32" r="30" stroke="white" stroke-width="1" opacity="0.2"/>
            
            <!-- W Letter (WordPress) - Left Side -->
            <g transform="translate(10, 16)">
                <!-- W Shape -->
                <path d="M2 4 L2 20 L8 14 L14 20 L14 4" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <path d="M2 4 L8 10 L14 4" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <!-- WordPress Circle -->
                <circle cx="8" cy="12" r="4.5" stroke="white" stroke-width="2.5" fill="none"/>
                <path d="M6 12 L8 7 L10 12" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </g>
            
            <!-- Server/Cloud Icon (Hosting) - Right Side -->
            <g transform="translate(36, 22)">
                <!-- Server Box -->
                <rect x="0" y="0" width="20" height="14" rx="2.5" fill="white" opacity="0.95"/>
                <rect x="0" y="0" width="20" height="14" rx="2.5" stroke="#6366f1" stroke-width="1" opacity="0.3"/>
                
                <!-- Server Indicators -->
                <rect x="3" y="3" width="4" height="4" rx="1" fill="#6366f1"/>
                <rect x="8.5" y="3" width="4" height="4" rx="1" fill="#6366f1"/>
                <rect x="14" y="3" width="4" height="4" rx="1" fill="#6366f1"/>
                
                <!-- Status Line -->
                <line x1="3" y1="9.5" x2="17" y2="9.5" stroke="#6366f1" stroke-width="2" stroke-linecap="round"/>
                
                <!-- Status Dots -->
                <circle cx="5" cy="12" r="1.5" fill="#6366f1"/>
                <circle cx="8.5" cy="12" r="1.5" fill="#6366f1"/>
                <circle cx="12" cy="12" r="1.5" fill="#6366f1"/>
            </g>
        </svg>
    </div>
    @if($showText)
        <!-- Text -->
        <div class="flex flex-col">
            <span class="{{ $textSize }} font-bold {{ $textColorClass }} leading-tight tracking-tight">WPHCP</span>
            <span class="{{ $subtextSize }} {{ $subtextColorClass }} leading-tight hidden sm:block">WordPress Hosting</span>
        </div>
    @endif
</div>
