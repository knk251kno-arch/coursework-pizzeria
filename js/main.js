// Автоматичний вибір піци при кліку на кнопку в меню
function selectPizza(id, name) {
    const selectElement = document.getElementById('pizza_select');
    if (selectElement) {
        selectElement.value = id;
        // Візуальний фокус на форму
        selectElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        selectElement.style.backgroundColor = '#fff3cd';
        setTimeout(() => {
            selectElement.style.backgroundColor = '#fff';
        }, 800);
    }
}

// Обробка форми замовлення після завантаження сторінки
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('checkout-form');
    const statusBox = document.getElementById('order-status');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Скасовуємо перезавантаження сторінки

            // Збираємо дані з полів форми
            const pizzaId = document.getElementById('pizza_select').value;
            const clientName = document.getElementById('client_name').value.trim();
            const clientPhone = document.getElementById('client_phone').value.trim();
            const address = document.getElementById('address').value.trim();

            // Формуємо об'єкт для відправки
            const requestData = {
                pizza_id: pizzaId,
                client_name: clientName,
                client_phone: clientPhone,
                address: address
            };

            // Приховуємо попередній статус та вимикаємо кнопку під час відправки
            statusBox.style.display = 'none';
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Відправка...';

            // Виконуємо асинхронний FETCH запит на сервер з передачею JSON
            fetch('order?action=create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Помилка сервера');
                }
                return response.json(); // Очікуємо JSON відповідь
            })
            .then(data => {
                statusBox.style.display = 'block';
                
                if (data.status === 'success') {
                    // Виводимо зелений успішний бокс
                    statusBox.className = 'success-box';
                    statusBox.innerHTML = `<strong>✨ ${data.message}</strong>`;
                    form.reset(); // Очищуємо форму
                } else {
                    // Виводимо червоний бокс помилки
                    statusBox.className = 'error-box';
                    statusBox.innerHTML = `<strong>⚠️ Помилка:</strong> ${data.message}`;
                }
            })
            .catch(error => {
                statusBox.style.display = 'block';
                statusBox.className = 'error-box';
                statusBox.innerHTML = '<strong>⚠️ Критична помилка:</strong> Не вдалося з\'єднатися із сервером.';
                console.error(error);
            })
            .finally(() => {
                // Повертаємо кнопку в початковий стан
                submitBtn.disabled = false;
                submitBtn.innerText = 'Надіслати замовлення';
            });
        });
    }
});
