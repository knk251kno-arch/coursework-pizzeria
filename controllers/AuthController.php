<?php
class AuthController extends Controller 
{
    public function execute(): void 
    {
        $db = Database::getConnection();
        $action = $this->request->getParam('action', 'login');
        $error = '';
        $success = '';

        if ($action === 'logout') {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_login']);
            header("Location: ./");
            exit;
        }

        if ($action === 'register') {
            $login = trim($this->request->getParam('login', ''));
            $email = trim($this->request->getParam('email', ''));
            $password = $this->request->getParam('password', '');

            if ($this->request->getMethod() === 'POST') {
                if ($login === '' || $email === '' || $password === '') {
                    $error = "Усі поля є обов'язковими!";
                } elseif (strlen($password) < 6) {
                    $error = "Пароль має бути не менше 6 символів!";
                } else {
                    try {
                        $stmt = $db->prepare("SELECT id FROM users WHERE login = :login");
                        $stmt->execute(['login' => $login]);
                        if ($stmt->fetch()) {
                            $error = "Користувач з таким логіном вже існує!";
                        } else {
                            $stmt = $db->prepare("INSERT INTO users (login, email, password) VALUES (:login, :email, :password)");
                            $stmt->execute([
                                'login' => $login,
                                'email' => $email,
                                'password' => password_hash($password, PASSWORD_DEFAULT)
                            ]);
                            header("Location: auth?action=login&registered=1");
                            exit;
                        }
                    } catch (PDOException $e) {
                        $error = "Помилка реєстрації: " . $e->getMessage();
                    }
                }
            }
            $this->view->renderPage('auth/register', ['error' => $error], 'Реєстрація персоналу');
            return;
        }

        // Авторизация (Вход)
        if ($this->request->getParam('registered') === '1') {
            $success = "Реєстрація успішна! Тепер ви можете увійти.";
        }

        if ($this->request->getMethod() === 'POST') {
            $login = trim($this->request->getParam('login', ''));
            $password = $this->request->getParam('password', '');

            try {
                $stmt = $db->prepare("SELECT * FROM users WHERE login = :login");
                $stmt->execute(['login' => $login]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_login'] = $user['login'];
                    header("Location: ./");
                    exit;
                } else {
                    $error = "Невірний логін або пароль!";
                }
            } catch (PDOException $e) {
                $error = "Помилка бази даних: " . $e->getMessage();
            }
        }

        $this->view->renderPage('auth/login', ['error' => $error, 'success' => $success], 'Вхід для персоналу');
    }
}
