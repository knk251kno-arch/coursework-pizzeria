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
            // Якщо таблиця ще порожня, сторінка просто виведе повідомлення
        }

        $this->view->renderPage('home/main', ['pizzas' => $pizzas], 'Головна та Меню');
    }
}
