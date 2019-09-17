<?php

/**
 * Register application modules
 */

$application->registerModules([
    'api' => [
        'className' => 'Modules\Api\Module',
        'path' => APP_PATH . '/api/Module.php'
    ],
    'frontend' => [
        'className' => 'Modules\Frontend\Module',
        'path' => APP_PATH . '/frontend/Module.php'
    ],
    'backend' => [
        'className' => 'Modules\Backend\Module',
        'path' => APP_PATH . '/backend/Module.php'
    ],
]);