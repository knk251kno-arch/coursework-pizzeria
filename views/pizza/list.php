<h2>Керування каталогом піц  🛠</h2>
<p style="margin-bottom: 20px; color: #666;">Тут ви можете додавати нові кулінарні позиції, редагувати наявні параметри або прибирати страви з меню.</p>

<?php if (!empty($success)): ?>
    <div class="success-box" style="margin-bottom: 20px;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="error-box" style="margin-bottom: 20px;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<p style="margin-bottom: 25px;">
    <a href="pizza?action=create" class="btn">+ Додати нову піцу</a>
</p>

<?php if (!empty($pizzas)): ?>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #222; color: #fff;">
                <th>ID</th>
                <th>Фото</th>
                <th>Назва</th>
                <th>Розмір</th>
                <th>Вага</th>
                <th>Ціна</th>
                <th style="width: 40%;">Склад / Інгредієнти</th>
                <th style="text-align: center;">Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pizzas as $p): ?>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td><?= $p['id'] ?></td>
                    <td>
                        <?php if ($p['image']): ?>
                            <img src="<?= htmlspecialchars($p['image']) ?>" alt="піца" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        <?php else: ?>
                            <span style="font-size: 24px;">🍕</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight: bold; color: #e64a19;"><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['size']) ?></td>
                    <td><?= (int)$p['weight_g'] ?> г</td>
                    <td style="font-weight: bold;"><?= number_format($p['price'], 2) ?> грн</td>
                    <td style="font-size: 14px; color: #555;"><?= htmlspecialchars($p['ingredients']) ?></td>
                    <td style="text-align: center; font-size: 14px;">
                        <a href="pizza?action=edit&id=<?= $p['id'] ?>" style="color: #ff5722; text-decoration: none; font-weight: bold; margin-right: 15px;">Редагувати</a>
                        <a href="pizza?action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Видалити піцу &quot;<?= htmlspecialchars($p['name']) ?>&quot;?');" style="color: #d32f2f; text-decoration: none; font-weight: bold;">Видалити</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="color: #888; font-style: italic;">Каталог страв наразі порожній.</p>
<?php endif; ?>
