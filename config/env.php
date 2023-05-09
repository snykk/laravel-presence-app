<?php

return [
    'APP_HOST'        => env('APP_HOST', 'localhost'),
    'VARNISH_ENABLED' => env('VARNISH_ENABLED', false),
    'BACKUP_ENABLED'  => env('BACKUP_ENABLED', false),
    'HORIZON_AUTH'    => explode(',', env('HORIZON_AUTH', 'admin@admin.com')),
];
