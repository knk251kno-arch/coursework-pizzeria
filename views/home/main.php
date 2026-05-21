<div class="welcome-section" style="text-align: center; margin-bottom: 40px;">
    <h1 style="font-size: 36px; margin-bottom: 10px; color: #e64a19;">Свіжа та Гаряча Піца! 🍕</h1>
    <p style="font-size: 18px; color: #666;">Оберіть свою улюблену піцу та отримайте безкоштовну доставку за 30 хвилин.</p>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">

    <div>
        <h2>Наше Меню</h2>
        <?php if (!empty($pizzas)): ?>
            <div class="pizza-menu">
                <?php foreach ($pizzas as $pizza): ?>
                    <div class="menu-item">
                        <div>

                            <div style="width: 100%; height: 180px; overflow: hidden; border-radius: 6px; margin-bottom: 15px; background: #eee;">
                                <?php if ($pizza['image']): ?>
                                    <img src="<?= htmlspecialchars($pizza['image']) ?>" alt="<?= htmlspecialchars($pizza['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; font-size: 48px; background: #f5f5f5;">🍕</div>
                                <?php endif; ?>
                            </div>

                            <h3>🍕 <?= htmlspecialchars($pizza['name']) ?></h3>
                            <p style="color: #666; font-size: 14px; margin-bottom: 8px;">
                                <strong>Склад:</strong> <?= htmlspecialchars($pizza['ingredients']) ?>
                            </p>
                            <p style="font-size: 13px; color: #888;">Розмір: <?= htmlspecialchars($pizza['size']) ?> | Вага: <?= (int)$pizza['weight_g'] ?> г</p>
                        </div>
                        <div>
                            <span class="pizza-price"><?= number_format($pizza['price'], 2) ?> грн</span>
                            <button type="button" class="btn" style="width: 100%; padding: 6px 12px; font-size: 14px;" 
                                    onclick="selectPizza(<?= $pizza['id'] ?>, '<?= htmlspecialchars($pizza['name']) ?>')">
                                Обрати для замовлення
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color: #888; font-style: italic; margin-top: 15px;">Наразі меню порожнє. Адміністратор ще не додав жодної піци у систему.</p>
        <?php endif; ?>
    </div>


    <div>
        <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-top: 4px solid #ff5722; position: sticky; top: 20px;">
            <h3>Швидке замовлення</h3>
            <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Оберіть страву з меню та заповніть контактні дані.</p>
            
            <div id="order-status" style="display: none;"></div>

            <form id="checkout-form">
                <div class="form-group">
                    <label for="pizza_select">Обрана піца *</label>
                    <select name="pizza_id" id="pizza_select" class="form-control" style="max-width: 100%; background: #fff;" required>
                        <option value="">-- Натисніть кнопку під піцою --</option>
                        <?php foreach ($pizzas as $pizza): ?>
                            <option value="<?= $pizza['id'] ?>"><?= htmlspecialchars($pizza['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="client_name">Ваше Ім'я *</label>
                    <input type="text" name="client_name" id="client_name" class="form-control" style="max-width: 100%;" required>
                </div>

                <div class="form-group">
                    <label for="client_phone">Телефон *</label>
                    <input type="text" name="client_phone" id="client_phone" class="form-control" style="max-width: 100%;" placeholder="+380..." required>
                </div>

                <div class="form-group">
                    <label for="address">Адреса доставки *</label>
                    <textarea name="address" id="address" class="form-control" style="max-width: 100%; height: 60px;" required></textarea>
                </div>

                <button type="submit" class="btn" style="width: 100%;">Надіслати замовлення</button>
            </form>
        </div>
    </div>
</div>
