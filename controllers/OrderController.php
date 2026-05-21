<?php
class OrderController extends Controller 
{
    public function execute(): void 
    {
        $db = Database::getConnection();
        $action = $this->request->getParam('action', 'list');
        $error = '';
        $success = '';


        if ($action === 'create' && $this->request->getMethod() === 'POST') {
            ob_clean();
            header('Content-Type: application/json; charset=utf-8');
            $data = $this->request->getJsonData();

            $pizzaId     = isset($data['pizza_id']) ? (int)$data['pizza_id'] : 0;
            $clientName  = isset($data['client_name']) ? trim($data['client_name']) : '';
            $clientPhone = isset($data['client_phone']) ? trim($data['client_phone']) : '';
            $address     = isset($data['address']) ? trim($data['address']) : '';

            if ($pizzaId <= 0 || $clientName === '' || $clientPhone === '' || $address === '') {
                echo json_encode(['status' => 'error', 'message' => 'Будь ласка, заповніть усі обов\'язкові поля!']);
                exit;
            }

            try {
                $stmt = $db->prepare("INSERT INTO orders (pizza_id, client_name, client_phone, address) VALUES (:pizza_id, :client_name, :client_phone, :address)");
                $stmt->execute(['pizza_id' => $pizzaId, 'client_name' => $clientName, 'client_phone' => $clientPhone, 'address' => $address]);
                echo json_encode(['status' => 'success', 'message' => 'Дякуємо! Ваше замовлення успішно прийнято в обробку.']);
                exit;
            } catch (PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => 'Помилка бази даних: ' . $e->getMessage()]);
                exit;
            }
        }


        if (!isset($_SESSION['user_id'])) {
            header("Location: auth?action=login");
            exit;
        }


        if ($action === 'delete') {
            $id = (int)$this->request->getParam('id', 0);
            if ($id > 0) {
                try {
                    $stmt = $db->prepare("DELETE FROM orders WHERE id = :id");
                    $stmt->execute(['id' => $id]);
                    header("Location: order?success=deleted");
                    exit;
                } catch (PDOException $e) {
                    die("Помилка видалення замовлення: " . $e->getMessage());
                }
            }
        }


        if ($action === 'update_status') {
            $orderId = (int)$this->request->getParam('id', 0);
            $newStatus = $this->request->getParam('status', 'new');

            if ($orderId > 0) {
                try {
                    $stmt = $db->prepare("UPDATE orders SET status = :status WHERE id = :id");
                    $stmt->execute(['status' => $newStatus, 'id' => $orderId]);
                } catch (PDOException $e) {
                    die("Помилка оновлення статусу: " . $e->getMessage());
                }
            }
            header("Location: order");
            exit;
        }

        $msg = $this->request->getParam('success', '');
        if ($msg === 'deleted') $success = "Замовлення успішно видалено з архіву системи.";


        $orders = [];
        try {
            $sql = "SELECT o.*, p.name as pizza_name, p.price as pizza_price, p.size as pizza_size 
                    FROM orders o 
                    JOIN pizzas p ON o.pizza_id = p.id 
                    ORDER BY o.id DESC";
            $stmt = $db->query($sql);
            $orders = $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Помилка завантаження замовлень: " . $e->getMessage());
        }

        $this->view->renderPage('order/list', ['orders' => $orders, 'success' => $success], 'Керування замовленнями');
    }
}
