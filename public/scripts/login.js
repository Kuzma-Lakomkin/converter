document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const errorContainer = document.querySelector('.error-message');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // Вставляем сообщение об ошибке внутри формы
                errorContainer.textContent = data.error;
            } else if (data.success) {
                alert(data.success);
                form.reset();
                window.location.href = '/converter/user/rate';
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
