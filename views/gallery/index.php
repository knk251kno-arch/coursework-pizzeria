<h2>Відгуки наших гостей (Модуль 5) 💬</h2>
<p style="margin-bottom: 20px; color: #666;">Поділіться своїми враженнями про якість обслуговування, швидкість доставки або смак нашої фірмової піци.</p>

<?php if (!empty($error)): ?>
    <div class="error-box"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success-box" style="margin-bottom: 20px;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<!-- Форма додавання відгуку (доступна для всіх відвідувачів) -->
<div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #ddd; margin-bottom: 35px;">
    <h3>Залишити свій відгук</h3>
    <form action="gallery" method="POST" style="margin-top: 15px;">
        <div class="form-group">
            <label for="client_name">Ваше Ім'я *</label>
            <input type="text" name="client_name" id="client_name" class="form-control" style="max-width: 100%;" required>
        </div>
        <div class="form-group">
            <label for="comment_text">Текст відгуку *</label>
            <textarea name="comment_text" id="comment_text" class="form-control" style="max-width: 100%; height: 90px;" required></textarea>
        </div>
        <button type="submit" class="btn">Опублікувати відгук</button>
    </form>
</div>

<h3>Архів коментарів</h3>
<div style="margin-top: 20px;">
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
            <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.01); border-left: 4px solid #ff5722;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                    <strong style="font-size: 16px; color: #222;">👤 <?= htmlspecialchars($review['title']) ?></strong>
                    <span style="font-size: 12px; color: #aaa;">Додано: <?= $review['uploaded_at'] ?></span>
                </div>
                <p style="font-size: 15px; color: #444; white-space: pre-line; margin-bottom: 10px;"><?= htmlspecialchars($review['image_path']) ?></p>
                
                <!-- Кнопка видалення: показується ТІЛЬКИ авторизованому адміну -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div style="text-align: right; margin-top: 5px;">
                        <a href="gallery?action=delete&id=<?= $review['id'] ?>" 
                           onclick="return confirm('Ви впевнені, що хочете видалити цей відгук?');" 
                           style="color: #d32f2f; text-decoration: none; font-size: 13px; font-weight: bold; background: #fdf2f2; padding: 4px 10px; border-radius: 4px; border: 1px solid #fde8e8;">
                            🗑️ Видалити відгук
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #888; font-style: italic;">Відгуків від гостей ще немає. Залиште свій коментар першим!</p>
    <?php endif; ?>
</div>
