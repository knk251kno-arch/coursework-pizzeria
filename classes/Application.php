<?php
class Application 
{
    private Request $request;
    private Router $router;

    public function __construct() 
    {
        $this->request = new Request();
        $this->router = new Router();
    }

    public function run(): void 
    {
        $controllerName = $this->router->resolve($this->request);
        
        if (class_exists($controllerName)) {
            $controller = new $controllerName($this->request);
            $controller->execute();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "Контролер $controllerName не знайдено.";
        }
    }
}
