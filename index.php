<?php
require_once __DIR__ . '/config/init.php';

try {
    $app = new Application();
    $app->run();
} catch (Exception $e) {
    echo "Критична помилка курсової роботи: " . $e->getMessage();
}
