<?php

return [
    'paths' => [
        'api/*',
        '/',
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'register',
        'user/profile-information',
        'email/verification-notification',
        'forgot-password',
        'reset-password',
        'user/confirm-password',
        'user/two-factor-authentication',
        'user/two-factor-recovery-codes',
        'user/two-factor-qr-code',
        'two-factor-challenge',
        'user/password',
        'socialite/*',
        'broadcasting/auth',
        'broadcasting/guest'
    ], // Allow API requests and Sanctum CSRF token cookie

    'allowed_methods' => ['*'],  // Allow all HTTP methods (GET, POST, etc.)

    'allowed_origins' => ['http://localhost:3000'],  // Allow your Vue.js app's domain

    'allowed_origins_patterns' => [],  // Optionally use patterns for allowed origins

    'allowed_headers' => ['*'],  // Allow all headers

    'exposed_headers' => [],  // Optionally expose specific headers

    'max_age' => 0,  // Cache the CORS preflight response for 0 seconds

    'supports_credentials' => true,
];
