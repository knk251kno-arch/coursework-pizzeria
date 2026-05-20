<h2>Гарячі Акції та Новини  📢</h2>
<p style="margin-bottom: 20px; color: #666;">Дізнавайтеся першими про нові смаки, акційні пропозиції та знижки нашої піцерії.</p>

<?php if (!empty($error)): ?>
    <div class="error-box"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success-box" style="margin-bottom: 20px;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['user_id'])): ?>
    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #ddd; margin-bottom: 30px;">
        <h3>Створити нову публікацію</h3>
        <form action="news?action=create" method="POST" style="margin-top: 15px;">
            <div class="form-group">
                <label for="title">Заголовок акції / новини *</label>
                <input type="text" name="title" id="title" class="form-control" style="max-width: 100%;" required>
            </div>
            <div class="form-group">
                <label for="content">Текст оголошення *</label>
                <textarea name="content" id="content" class="form-control" style="max-width: 100%; height: 100px;" required></textarea>
            </div>
            <button type="submit" class="btn">Опублікувати новину</button>
        </form>
    </div>
<?php endif; ?>

<div class="news-list" style="margin-top: 20px;">
    <?php if (!empty($newsList)): ?>
        <?php foreach ($newsList as $item): ?>
            <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <h3 style="color: #e64a19; margin-bottom: 5px;"><?= htmlspecialchars($item['title']) ?></h3>
                <span style="font-size: 12px; color: #999; display: block; margin-bottom: 10px;">Опубліковано: <?= $item['published_at'] ?></span>
                <p style="font-size: 15px; color: #444; white-space: pre-line; margin-bottom: 10px;"><?= htmlspecialchars($item['content']) ?></p>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div style="text-align: right;">
                        <a href="news?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Видалити цю публікацію?');" style="color: #d32f2f; text-decoration: none; font-size: 13px; font-weight: bold;">🗑️ Видалити новину</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #888; font-style: italic;">Наразі немає опублікованих акцій чи новин.</p>
    <?php endif; ?>
</div>
