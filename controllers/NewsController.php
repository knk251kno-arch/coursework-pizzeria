<?php
class NewsController extends Controller 
{
    public function execute(): void 
    {
        $db = Database::getConnection();
        $action = $this->request->getParam('action', 'list');
        $error = '';

        if ($action === 'create' && $this->request->getMethod() === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header("Location: auth");
                exit;
            }

            $title = trim($this->request->getParam('title', ''));
            $content = trim($this->request->getParam('content', ''));

            if ($title === '' || $content === '') {
                $error = "Усі поля новини є обов'язковими!";
            } else {
                try {
                    $stmt = $db->prepare("INSERT INTO news (title, content) VALUES (:title, :content)");
                    $stmt->execute(['title' => $title, 'content' => $content]);
                    header("Location: news");
                    exit;
                } catch (PDOException $e) {
                    $error = "Помилка збереження новини: " . $e->getMessage();
                }
            }
        }

        // Завантаження всіх новин для виведення
        $newsList = [];
        try {
            $stmt = $db->query("SELECT * FROM news ORDER BY id DESC");
            $newsList = $stmt->fetchAll();
        } catch (PDOException $e) {
            $error = "Помилка бази даних: " . $e->getMessage();
        }

        $this->view->renderPage('news/index', [
            'newsList' => $newsList,
            'error' => $error,
            'action' => $action
        ], 'Акції та Новини піцерії');
    }
}
