<h2>Додати нову піцу до меню</h2>
<p style="margin-bottom: 20px; color: #666;">Заповніть усі параметри, щоб страва відобразилася на вітрині для замовлень.</p>

<?php if (!empty($error)): ?>
    <div class="error-box"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="pizza?action=create" method="POST" enctype="multipart/form-data" style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #ddd;">
    <div class="form-group">
        <label for="name">Назва піци *</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($pizza['name']) ?>" required>
    </div>

    <div class="form-group">
        <label for="size">Розмір піци *</label>
        <select name="size" id="size" class="form-control" style="background:#fff;" required>
            <option value="мала" <?= $pizza['size'] === 'мала' ? 'selected' : '' ?>>Мала (25 см)</option>
            <option value="середня" <?= $pizza['size'] === 'середня' ? 'selected' : '' ?>>Середня (30 см)</option>
            <option value="велика" <?= $pizza['size'] === 'велика' ? 'selected' : '' ?>>Велика (40 см)</option>
        </select>
    </div>

    <div class="form-group">
        <label for="weight_g">Вага (в грамах) *</label>
        <input type="number" name="weight_g" id="weight_g" class="form-control" value="<?= htmlspecialchars($pizza['weight_g']) ?>" required>
    </div>

    <div class="form-group">
        <label for="price">Ціна (грн) *</label>
        <input type="text" name="price" id="price" class="form-control" value="<?= htmlspecialchars($pizza['price']) ?>" placeholder="Наприклад: 210.50" required>
    </div>

    <div class="form-group">
        <label for="ingredients">Інгредієнти / Склад страви *</label>
        <textarea name="ingredients" id="ingredients" class="form-control" style="height: 80px;" required><?= htmlspecialchars($pizza['ingredients']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="image">Фотографія піци (необов'язково)</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*" style="background: #fff;">
    </div>

    <button type="submit" class="btn">Зберегти позицію</button>
    <a href="pizza" style="margin-left: 15px; color: #666; text-decoration: none; font-weight: 500;">Скасувати</a>
</form>
