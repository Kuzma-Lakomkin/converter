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
        .then(response => {
            if (response.ok) {
                window.location.href = '/converter/user/rate';
            } else {
                return response.json();
            }
        })
        .then(data => {
            if (data.error) {
                errorContainer.textContent = data.error;
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
