// scripts.js

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const successMessage = document.querySelector('.aj_user_success-message');
    const errorMessage = document.querySelector('.aj_user_error-message');

    form.addEventListener('submit', function(event) {
        // Clear previous messages
        if (successMessage) successMessage.style.display = 'none';
        if (errorMessage) errorMessage.style.display = 'none';
        
        let valid = true;

        // Example validation logic
        const email = form.querySelector('input[type="email"]');
        if (email && !validateEmail(email.value)) {
            valid = false;
            displayMessage(errorMessage, 'Veuillez entrer un email valide.');
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
    }

    function displayMessage(element, message) {
        if (element) {
            element.innerHTML = `<p>${message}</p>`;
            element.style.display = 'block';
        }
    }
});
