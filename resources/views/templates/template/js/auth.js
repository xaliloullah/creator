// Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');

    forms.forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                // Add loading state
                form.classList.add('loading');
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = 'Processing...';

                // Simulate API call
                setTimeout(() => {
                    form.classList.remove('loading');
                    submitBtn.innerHTML = originalText;
                }, 2000);
            }
            form.classList.add('was-validated');
        });
    });

    

    // Password Confirmation Validation
    const password = document.getElementById('password');
    const confirmation = document.getElementById('password_confirmation');

    if (password && confirmation) {
        confirmation.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});
