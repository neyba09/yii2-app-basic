<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'smsApiKey' => getenv('SMS_API_KEY') ?: 'TEST_EMULATOR_KEY',
];
