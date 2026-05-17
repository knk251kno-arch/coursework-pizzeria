<?php
class View 
{
    protected string $viewsDir;

    public function __construct() 
    {
        $this->viewsDir = __DIR__ . '/../views/';
    }

    public function render(string $template, array $data = []): string 
    {
        extract($data);
        $templatePath = $this->viewsDir . $template . '.php';
        if (!file_exists($templatePath)) {
            return "Шаблон $template не знайдено за шляхом $templatePath";
        }
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }
}
