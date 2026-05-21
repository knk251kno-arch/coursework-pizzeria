<?php
class Router 
{
    private array $routes = [
        '/' => 'HomeController',            
        '/pizza' => 'PizzaController',        
        '/auth' => 'AuthController',          
        '/order' => 'OrderController',        
        '/news' => 'NewsController',          
        '/gallery' => 'GalleryController'     
    ];

    public function resolve(Request $request): string 
    {
        $uri = $request->getUri();
        return $this->routes[$uri] ?? 'HomeController';
    }
}
