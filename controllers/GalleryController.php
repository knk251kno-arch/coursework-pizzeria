<?php
class GalleryController extends Controller 
{
    public function execute(): void 
    {
        $db = Database::getConnection();
        $error = '';
        $success = '';

        if ($this->request->getMethod() === 'POST' && isset($_FILES['gallery_image'])) {
            $title = trim($this->request->getParam('title', ''));
            $file = $_FILES['gallery_image'];

            if ($title === '' || $file['error'] !== UPLOAD_ERR_OK) {
                $error = "Будь ласка, вкажіть назву страви та оберіть коректний файл!";
            } else {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($ext, $allowed)) {
                    $error = "Дозволені лише формати зображень JPG, PNG та WEBP!";
                } else {
                    $newName = uniqid('gallery_', true) . '.' . $ext;
                    $targetPath = __DIR__ . '/../uploads/' . $newName;

                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        try {
                            $dbImgPath = 'uploads/' . $newName;
                            $stmt = $db->prepare("INSERT INTO gallery (title, image_path) VALUES (:title, :image_path)");
                            $stmt->execute(['title' => $title, 'image_path' => $dbImgPath]);
                            $success = "Фотографію страви успішно додано до галереї!";
                        } catch (PDOException $e) {
                            $error = "Помилка бази даних: " . $e->getMessage();
                        }
                    } else {
                        $error = "Не вдалося зберегти файл на сервері.";
                    }
                }
            }
        }

        // Завантаження фотографій для виведення
        $photos = [];
        try {
            $stmt = $db->query("SELECT * FROM gallery ORDER BY id DESC");
            $photos = $stmt->fetchAll();
        } catch (PDOException $e) {
            $error = "Помилка завантаження фотографій: " . $e->getMessage();
        }

        $this->view->renderPage('gallery/index', [
            'photos' => $photos,
            'error' => $error,
            'success' => $success
        ], 'Фотогалерея страв');
    }
}
