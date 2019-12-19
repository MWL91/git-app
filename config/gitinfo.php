<?php

return [
    'defaults' => [
        'branch' => env('GITINFO_DEFAULT_BRANCH', 'master'),
        'service' => env('GITINFO_DEFAULT_SERVICE', 'github'),
    ] 
];