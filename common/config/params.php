<?php
return [
    'adminEmail'   => env('ADMIN_EMAIL_ADDRESS', 'admin@example.com'),
    'contactEmail' => env('CONTACT_EMAIL_ADDRESS', 'contact@example.com'),
    'supportEmail' => env('SUPPORT_EMAIL_ADDRESS', 'support@example.com'),

    // configured in mailer so not necessary to use, left just in case
    'senderEmail'  => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
    'senderName'   => env('MAIL_FROM_NAME', env('APP_NAME', 'Yii2') . ' Mailer'),

    'user.passwordResetTokenExpire' => convertHoursToSeconds(24),

    'signupValidation' => env('SIGNUP_VALIDATION', false),
];
