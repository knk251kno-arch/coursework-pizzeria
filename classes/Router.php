<?php
class Router 
{
    private array $routes = [
        '/' => 'HomeController',            // Головна та замовлення
        '/pizza' => 'PizzaController',        // Адмінка: CRUD Піц
        '/auth' => 'AuthController',          // Персонал: Вхід/Реєстрація
        '/order' => 'OrderController',        // Асинхронне замовлення та адмінка замовлень
        '/news' => 'NewsController',          // Акції: CRUD Новин
        '/gallery' => 'GalleryController'     // Фотогалерея страв
    ];

    public function resolve(Request $request): string 
    {
        $uri = $request->getUri();
        return $this->routes[$uri] ?? 'HomeController';
    }
}
