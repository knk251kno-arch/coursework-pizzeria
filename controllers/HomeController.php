<?php
class HomeController extends Controller 
{
    public function execute(): void 
    {
        $db = Database::getConnection();
        $pizzas = [];

        try {
            $stmt = $db->query("SELECT * FROM pizzas ORDER BY id DESC");
            $pizzas = $stmt->fetchAll();
        } catch (PDOException $e) {

        }

        $this->view->renderPage('home/main', ['pizzas' => $pizzas], 'Головна та Меню');
    }
}
