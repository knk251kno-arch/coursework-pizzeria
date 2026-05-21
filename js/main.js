
function selectPizza(id, name) {
    const selectElement = document.getElementById('pizza_select');
    if (selectElement) {
        selectElement.value = id;

        selectElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        selectElement.style.backgroundColor = '#fff3cd';
        setTimeout(() => {
            selectElement.style.backgroundColor = '#fff';
        }, 800);
    }
}


document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('checkout-form');
    const statusBox = document.getElementById('order-status');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); 


            const pizzaId = document.getElementById('pizza_select').value;
            const clientName = document.getElementById('client_name').value.trim();
            const clientPhone = document.getElementById('client_phone').value.trim();
            const address = document.getElementById('address').value.trim();


            const requestData = {
                pizza_id: pizzaId,
                client_name: clientName,
                client_phone: clientPhone,
                address: address
            };


            statusBox.style.display = 'none';
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Відправка...';


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
                return response.json();
            })
            .then(data => {
                statusBox.style.display = 'block';
                
                if (data.status === 'success') {

                    statusBox.className = 'success-box';
                    statusBox.innerHTML = `<strong>✨ ${data.message}</strong>`;
                    form.reset();
                } else {

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

                submitBtn.disabled = false;
                submitBtn.innerText = 'Надіслати замовлення';
            });
        });
    }
});
