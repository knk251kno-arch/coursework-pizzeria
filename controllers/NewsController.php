<?php
class NewsController extends Controller 
{
    public function execute(): void 
    {
        $db = Database::getConnection();
        $action = $this->request->getParam('action', 'list');
        $error = '';
        $success = '';

        // ВИДАЛЕННЯ НОВИНИ (Тільки для адміна)
        if ($action === 'delete') {
            if (!isset($_SESSION['user_id'])) {
                header("Location: auth");
                exit;
            }
            $id = (int)$this->request->getParam('id', 0);
            if ($id > 0) {
                try {
                    $stmt = $db->prepare("DELETE FROM news WHERE id = :id");
                    $stmt->execute(['id' => $id]);
                    header("Location: news?success=deleted");
                    exit;
                } catch (PDOException $e) {
                    $error = "Помилка видалення новини: " . $e->getMessage();
                }
            }
        }

        // СТВОРЕННЯ НОВИНИ
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
                    header("Location: news?success=created");
                    exit;
                } catch (PDOException $e) {
                    $error = "Помилка збереження новини: " . $e->getMessage();
                }
            }
        }

        $msg = $this->request->getParam('success', '');
        if ($msg === 'created') $success = "Новину успішно опубліковано!";
        if ($msg === 'deleted') $success = "Новину видалено модератором.";

        // Завантаження всіх новин
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
            'success' => $success,
            'action' => $action
        ], 'Акції та Новини піцерії');
    }
}
