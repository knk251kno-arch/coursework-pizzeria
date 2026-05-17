<h2>Система керування замовленнями (Модуль 3) 🛒</h2>
<p style="margin-bottom: 20px; color: #666;">Поточні замовлення від клієнтів, які надійшли асинхронно через JSON/AJAX. Керуйте етапами приготування та доставки страв.</p>

<?php if (!empty($orders)): ?>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #222; color: #fff;">
                <th>ID</th>
                <th>Час замовлення</th>
                <th>Клієнт</th>
                <th>Контакти</th>
                <th>Адреса доставки</th>
                <th>Страва та ціна</th>
                <th>Статус</th>
                <th style="text-align: center;">Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td><?= $order['id'] ?></td>
                    <td style="font-size: 13px; color: #666;"><?= $order['created_at'] ?></td>
                    <td style="font-weight: bold;"><?= htmlspecialchars($order['client_name']) ?></td>
                    <td><?= htmlspecialchars($order['client_phone']) ?></td>
                    <td style="font-size: 14px; color: #444;"><?= htmlspecialchars($order['address']) ?></td>
                    <td>
                        <span style="color: #e64a19; font-weight: bold;">🍕 <?= htmlspecialchars($order['pizza_name']) ?></span>
                        <br><span style="font-size: 13px; color: #777;"><?= number_format($order['pizza_price'], 2) ?> грн</span>
                    </td>
                    <td>
                        <?php 
                        $statusMap = ['new' => '🆕 Нове', 'cooking' => '👨‍🍳 Готується', 'delivered' => '✅ Доставлено'];
                        echo $statusMap[$order['status']] ?? $order['status'];
                        ?>
                    </td>
                    <td style="text-align: center; font-size: 14px;">
                        <?php if ($order['status'] === 'new'): ?>
                            <a href="order?action=update_status&id=<?= $order['id'] ?>&status=cooking" style="color: #ff5722; text-decoration: none; font-weight: bold; margin-right: 10px;">Взяти в роботу</a>
                        <?php echo " "; endif; ?>
                        
                        <?php if ($order['status'] === 'cooking'): ?>
                            <a href="order?action=update_status&id=<?= $order['id'] ?>&status=delivered" style="color: #2e7d32; text-decoration: none; font-weight: bold; margin-right: 10px;">Доставлено</a>
                        <?php echo " "; endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="color: #888; font-style: italic; margin-top: 15px;">Активних замовлень у системі наразі немає.</p>
<?php endif; ?>
