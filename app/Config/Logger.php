<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Logger extends BaseConfig
{
    public $threshold = 4; // Pastikan 4 (semua log)
    
    public $handlers = [
        'CodeIgniter\Log\Handlers\FileHandler' => [
            'handles' => ['critical', 'alert', 'emergency', 'debug', 'error', 'info', 'notice', 'warning'],
            'fileExtension' => '',
            'filePermissions' => 0644,
            'path' => WRITEPATH . 'logs/',
        ],
    ];
}