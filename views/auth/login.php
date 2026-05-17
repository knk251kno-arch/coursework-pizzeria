<div style="max-width: 450px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-top: 4px solid #ff5722;">
    <h2 style="margin-bottom: 20px; text-align: center; color: #222;">Вхід для персоналу</h2>

    <?php if (!empty($success)): ?>
        <div class="success-box" style="margin-bottom: 15px; font-size: 14px;"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="error-box" style="margin-bottom: 15px; font-size: 14px;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="auth?action=login" method="POST">
        <div class="form-group">
            <label for="login">Логін адміністратора:</label>
            <input type="text" name="login" id="login" class="form-control" style="max-width: 100%;" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" class="form-control" style="max-width: 100%;" required>
        </div>
        <button type="submit" class="btn" style="width: 100%; margin-top: 10px;">Увійти в систему</button>
    </form>
    <p style="margin-top: 20px; text-align: center; font-size: 14px; color: #666;">
        Вперше тут? <a href="auth?action=register" style="color: #ff5722; font-weight: bold; text-decoration: none;">Зареєструвати акаунт</a>
    </p>
</div>
