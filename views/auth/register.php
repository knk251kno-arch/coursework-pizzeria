<div style="max-width: 450px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-top: 4px solid #ff5722;">
    <h2 style="margin-bottom: 20px; text-align: center; color: #222;">Реєстрація співробітника</h2>

    <?php if (!empty($error)): ?>
        <div class="error-box" style="margin-bottom: 15px; font-size: 14px;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="auth?action=register" method="POST">
        <div class="form-group">
            <label for="login">Логін:</label>
            <input type="text" name="login" id="login" class="form-control" style="max-width: 100%;" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail робочий:</label>
            <input type="email" name="email" id="email" class="form-control" style="max-width: 100%;" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль (від 6 знаків):</label>
            <input type="password" name="password" id="password" class="form-control" style="max-width: 100%;" required>
        </div>
        <div class="form-group" style="background: #fff3cd; padding: 10px; border-radius: 4px; border: 1px solid #ffeeba;">
            <label for="secret_code" style="color: #856404;">Секретний код доступу шефа *</label>
            <input type="password" name="secret_code" id="secret_code" class="form-control" style="max-width: 100%; border-color: #ffeeba;" placeholder="Введіть код для реєстрації адмінів" required>
        </div>
        <button type="submit" class="btn" style="width: 100%; margin-top: 10px;">Створити обліковий запис</button>
    </form>
    <p style="margin-top: 20px; text-align: center; font-size: 14px; color: #666;">
        Вже є акаунт? <a href="auth?action=login" style="color: #ff5722; font-weight: bold; text-decoration: none;">Увійти</a>
    </p>
</div>
