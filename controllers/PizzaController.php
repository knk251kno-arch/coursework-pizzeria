<?php
class PizzaController extends Controller 
{
    public function execute(): void 
    {
        // Захист модуля: керувати каталогом може лише авторизований персонал
        if (!isset($_SESSION['user_id'])) {
            header("Location: auth?action=login");
            exit;
        }

        $db = Database::getConnection();
        $action = $this->request->getParam('action', 'list');
        $error = '';
        $success = '';

        // 1. ВИДАЛЕННЯ ПІЦИ
        if ($action === 'delete') {
            $id = (int)$this->request->getParam('id', 0);
            if ($id > 0) {
                try {
                    // Спочатку дізнаємося назву файлу картинки, щоб видалити її з диска
                    $stmt = $db->prepare("SELECT image FROM pizzas WHERE id = :id");
                    $stmt->execute(['id' => $id]);
                    $pizza = $stmt->fetch();
                    if ($pizza && $pizza['image'] && file_exists(__DIR__ . '/../' . $pizza['image'])) {
                        unlink(__DIR__ . '/../' . $pizza['image']);
                    }

                    $stmt = $db->prepare("DELETE FROM pizzas WHERE id = :id");
                    $stmt->execute(['id' => $id]);
                    header("Location: pizza?success=deleted");
                    exit;
                } catch (PDOException $e) {
                    $error = "Помилка видалення: " . $e->getMessage();
                }
            }
        }

        // 2. СТВОРЕННЯ ПІЦИ
        if ($action === 'create') {
            $pizza = ['name' => '', 'size' => 'середня', 'price' => '', 'ingredients' => '', 'weight_g' => ''];

            if ($this->request->getMethod() === 'POST') {
                $pizza['name'] = trim($this->request->getParam('name', ''));
                $pizza['size'] = $this->request->getParam('size', 'середня');
                $pizza['price'] = trim($this->request->getParam('price', ''));
                $pizza['ingredients'] = trim($this->request->getParam('ingredients', ''));
                $pizza['weight_g'] = trim($this->request->getParam('weight_g', ''));

                if ($pizza['name'] === '' || $pizza['price'] === '' || $pizza['ingredients'] === '' || $pizza['weight_g'] === '') {
                    $error = "Усі поля є обов'язковими!";
                } elseif (!is_numeric($pizza['price']) || (float)$pizza['price'] <= 0) {
                    $error = "Ціна повинна бути додатним числом!";
                } elseif (!is_numeric($pizza['weight_g']) || (int)$pizza['weight_g'] <= 0) {
                    $error = "Вага повинна бути додатним цілим числом!";
                } else {
                    $imagePath = null;
                    // Обробка завантаження картинки
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                            $newImgName = uniqid('pizza_crud_', true) . '.' . $ext;
                            if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $newImgName)) {
                                $imagePath = 'uploads/' . $newImgName;
                            }
                        }
                    }

                    try {
                        $stmt = $db->prepare("INSERT INTO pizzas (name, size, price, ingredients, weight_g, image) VALUES (:name, :size, :price, :ingredients, :weight_g, :image)");
                        $stmt->execute([
                            'name' => $pizza['name'],
                            'size' => $pizza['size'],
                            'price' => (float)$pizza['price'],
                            'ingredients' => $pizza['ingredients'],
                            'weight_g' => (int)$pizza['weight_g'],
                            'image' => $imagePath
                        ]);
                        header("Location: pizza?success=created");
                        exit;
                    } catch (PDOException $e) {
                        $error = "Помилка збереження в БД: " . $e->getMessage();
                    }
                }
            }
            $this->view->renderPage('pizza/create', ['error' => $error, 'pizza' => $pizza], 'Додати нову піцу');
            return;
        }

        // 3. РЕДАКУВАННЯ ПІЦИ
        if ($action === 'edit') {
            $id = (int)$this->request->getParam('id', 0);
            try {
                $stmt = $db->prepare("SELECT * FROM pizzas WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $pizza = $stmt->fetch();
            } catch (PDOException $e) {
                die("Помилка запиту: " . $e->getMessage());
            }

            if (!$pizza) {
                die("Піцу з ID $id не знайдено.");
            }

            if ($this->request->getMethod() === 'POST') {
                $pizza['name'] = trim($this->request->getParam('name', ''));
                $pizza['size'] = $this->request->getParam('size', 'середня');
                $pizza['price'] = trim($this->request->getParam('price', ''));
                $pizza['ingredients'] = trim($this->request->getParam('ingredients', ''));
                $pizza['weight_g'] = trim($this->request->getParam('weight_g', ''));

                if ($pizza['name'] === '' || $pizza['price'] === '' || $pizza['ingredients'] === '' || $pizza['weight_g'] === '') {
                    $error = "Усі поля є обов'язковими!";
                } elseif (!is_numeric($pizza['price']) || (float)$pizza['price'] <= 0) {
                    $error = "Ціна повинна бути додатним числом!";
                } elseif (!is_numeric($pizza['weight_g']) || (int)$pizza['weight_g'] <= 0) {
                    $error = "Вага повинна бути цілим додатним числом!";
                } else {
                    $imagePath = $pizza['image'];
                    // Якщо завантажено нову картинку, замінюємо її
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                            $newImgName = uniqid('pizza_crud_', true) . '.' . $ext;
                            if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $newImgName)) {
                                // Видаляємо стару картинку з диска
                                if ($pizza['image'] && file_exists(__DIR__ . '/../' . $pizza['image'])) {
                                    unlink(__DIR__ . '/../' . $pizza['image']);
                                }
                                $imagePath = 'uploads/' . $newImgName;
                            }
                        }
                    }

                    try {
                        $stmt = $db->prepare("UPDATE pizzas SET name = :name, size = :size, price = :price, ingredients = :ingredients, weight_g = :weight_g, image = :image WHERE id = :id");
                        $stmt->execute([
                            'id' => $id,
                            'name' => $pizza['name'],
                            'size' => $pizza['size'],
                            'price' => (float)$pizza['price'],
                            'ingredients' => $pizza['ingredients'],
                            'weight_g' => (int)$pizza['weight_g'],
                            'image' => $imagePath
                        ]);
                        header("Location: pizza?success=updated");
                        exit;
                    } catch (PDOException $e) {
                        $error = "Помилка оновлення БД: " . $e->getMessage();
                    }
                }
            }
            $this->view->renderPage('pizza/edit', ['error' => $error, 'pizza' => $pizza, 'id' => $id], 'Редагувати піцу');
            return;
        }

        // 4. СПИСОК ПІЦ (Панель керування)
        $msg = $this->request->getParam('success', '');
        if ($msg === 'created') $success = "Страву успішно додано до меню!";
        if ($msg === 'updated') $success = "Дані піци успішно оновлено!";
        if ($msg === 'deleted') $success = "Піцу видалено з каталогу.";

        try {
            $stmt = $db->query("SELECT * FROM pizzas ORDER BY id DESC");
            $pizzas = $stmt->fetchAll();
        } catch (PDOException $e) {
            $pizzas = [];
            $error = "Помилка завантаження: " . $e->getMessage();
        }

        $this->view->renderPage('pizza/list', ['pizzas' => $pizzas, 'error' => $error, 'success' => $success], 'Керування каталогом');
    }
}
