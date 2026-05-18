<?php
class GalleryController extends Controller 
{
    public function execute(): void 
    {
        $db = Database::getConnection();
        $error = '';
        $success = '';
        $action = $this->request->getParam('action', 'list');

        // 1. ВИДАЛЕННЯ ВІДГУКУ (Тільки для адміна)
        if ($action === 'delete') {
            if (!isset($_SESSION['user_id'])) {
                header("Location: auth?action=login");
                exit;
            }

            $id = (int)$this->request->getParam('id', 0);
            if ($id > 0) {
                try {
                    $stmt = $db->prepare("DELETE FROM gallery WHERE id = :id");
                    $stmt->execute(['id' => $id]);
                    header("Location: gallery?success=deleted");
                    exit;
                } catch (PDOException $e) {
                    $error = "Помилка видалення відгуку: " . $e->getMessage();
                }
            }
        }

        // 2. ОБРОБКА ВІДПРАВКИ НОВОГО ВІДГУКУ (Доступно всім)
        if ($this->request->getMethod() === 'POST') {
            $clientName = trim($this->request->getParam('client_name', ''));
            $commentText = trim($this->request->getParam('comment_text', ''));

            if ($clientName === '' || $commentText === '') {
                $error = "Будь ласка, заповніть усі поля відгуку!";
            } else {
                try {
                    $stmt = $db->prepare("INSERT INTO gallery (title, image_path) VALUES (:title, :image_path)");
                    $stmt->execute([
                        'title' => $clientName,
                        'image_path' => $commentText
                    ]);
                    header("Location: gallery?success=created");
                    exit;
                } catch (PDOException $e) {
                    $error = "Помилка збереження відгуку: " . $e->getMessage();
                }
            }
        }

        // Статусні повідомлення
        $msg = $this->request->getParam('success', '');
        if ($msg === 'created') $success = "Дякуємо! Ваш відгук успішно опубліковано.";
        if ($msg === 'deleted') $success = "Відгук успішно видалено модератором.";

        // Завантаження всіх відгуків для виведення
        $reviews = [];
        try {
            $stmt = $db->query("SELECT * FROM gallery ORDER BY id DESC");
            $reviews = $stmt->fetchAll();
        } catch (PDOException $e) {
            $error = "Помилка завантаження відгуків: " . $e->getMessage();
        }

        $this->view->renderPage('gallery/index', [
            'reviews' => $reviews,
            'error' => $error,
            'success' => $success
        ], 'Відгуки клієнтів');
    }
}
