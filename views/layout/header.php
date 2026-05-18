<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — Pizzeria Admin Pro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="site-header">
    <div class="header-container">
        <div class="logo">🍕 Pizzeria Admin Pro</div>
        <nav class="main-nav">
            <a href="./">Головна & Меню</a>
            <a href="gallery">Відгуки клієнтів</a>
            <a href="news">Акції та Новини</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="pizza" class="admin-link">Керування Піцами</a>
                <a href="order" class="admin-link">Замовлення</a>
                <a href="auth?action=logout" class="logout-btn">Вийти (@<?= htmlspecialchars($_SESSION['user_login']) ?>)</a>
            <?php else: ?>
                <a href="auth" class="login-btn">Вхід для персоналу</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="page-content">
