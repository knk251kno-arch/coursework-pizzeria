<?php
session_start();

spl_autoload_register(function ($className) {
    $dirs = [
        __DIR__ . '/../classes/',
        __DIR__ . '/../controllers/'
    ];
    
    foreach ($dirs as $dir) {
        $file = $dir . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
