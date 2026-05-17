<h2>Фотогалерея наших страв (Модуль 5) 📷</h2>
<p style="margin-bottom: 20px; color: #666;">Реальні фотографії наших свіжоспечених піц від шеф-кухарів ресторанної мережі.</p>

<?php if (!empty($error)): ?>
    <div class="error-box"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success-box" style="margin-bottom: 20px;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['user_id'])): ?>
    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #ddd; margin-bottom: 30px;">
        <h3>Завантажити нове фото до галереї</h3>
        <form action="gallery" method="POST" enctype="multipart/form-data" style="margin-top: 15px;">
            <div class="form-group">
                <label for="title">Назва або опис страви *</label>
                <input type="text" name="title" id="title" class="form-control" style="max-width: 100%;" required>
            </div>
            <div class="form-group">
                <label for="gallery_image">Оберіть файл картинки (JPG, PNG, WEBP) *</label>
                <input type="file" name="gallery_image" id="gallery_image" class="form-control" accept="image/*" style="background: #fff; max-width: 100%;" required>
            </div>
            <button type="submit" class="btn">Завантажити фотографію</button>
        </form>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; margin-top: 20px;">
    <?php if (!empty($photos)): ?>
        <?php foreach ($photos as $photo): ?>
            <div style="background: #fff; border: 1px solid #ddd; padding: 12px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); text-align: center;">
                <img src="<?= htmlspecialchars($photo['image_path']) ?>" alt="Фото" style="width: 100%; height: 180px; object-fit: cover; border-radius: 6px; display: block; margin-bottom: 10px;">
                <strong style="color: #333; font-size: 15px; display: block;"><?= htmlspecialchars($photo['title']) ?></strong>
                <span style="font-size: 11px; color: #aaa; display: block; margin-top: 4px;">Додано: <?= $photo['uploaded_at'] ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #888; font-style: italic; grid-column: 1 / -1;">В галереї страв поки немає жодної фотографії.</p>
    <?php endif; ?>
</div>
