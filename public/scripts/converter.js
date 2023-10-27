const fromCurrency = document.getElementById("fromCurrency");
const toCurrency = document.getElementById("toCurrency");

fromCurrency.addEventListener("change", function() {
    if (fromCurrency.value === '643') {
        toCurrency.disabled = false;
    } else {
        toCurrency.value = '643';
        toCurrency.disabled = true;
    }
});

const fromAmount = document.getElementById("fromAmount");
fromAmount.addEventListener("input", function() {
    fromAmount.value = fromAmount.value.replace(/[^0-9.,]+/g, '');
});

fromCurrency.dispatchEvent(new Event('change'));

const form = document.querySelector('form');
const resultField = document.getElementById("amount");

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(form);

    // AJAX-запрос к методу converter на сервере
    fetch('/converter/user/converter', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        resultField.value = data.amount;
    })
    .catch(error => {
        console.error('Ошибка при выполнении запроса:', error);
    });
});
