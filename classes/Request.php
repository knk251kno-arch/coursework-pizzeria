<?php
class Request 
{
    public function getMethod(): string 
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUri(): string 
    {
        $uri = $_SERVER['REQUEST_URI'];
        $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
        if (strpos($uri, $scriptPath) === 0) {
            $uri = substr($uri, strlen($scriptPath));
        }
        
  
        $position = strpos($uri, '?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }
        
        return '/' . trim($uri, '/');
    }

    public function getParam(string $key, $default = null) 
    {
        return $_GET[$key] ?? $_POST[$key] ?? $default;
    }

    // Отримання асинхронних JSON даних (AJAX)
    public function getJsonData(): array 
    {
        $json = file_get_contents('php://input');
        return json_decode($json, true) ?? [];
    }
}