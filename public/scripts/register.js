document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registration-form');
    const errorContainer = document.getElementById('error-container');
    
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        fetch('/converter/account/register', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            // Очищаем контейнер с ошибками перед добавлением новых сообщений
            errorContainer.innerHTML = '';
            if (data.error) {
                // Ошибка валидации, выводим ошибки
                for (const field in data.error) {
                    for (const error of data.error[field]) {
                        const errorElement = document.createElement('div');
                        errorElement.textContent = error;
                        errorContainer.appendChild(errorElement);
                    }
                }
            } else {
                alert('Регистрация прошла успешно');
                form.reset();
                window.location.href = '/converter/account/login';
            }
        })
        .catch(error => console.error(error));
    });
});
