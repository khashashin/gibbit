// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        const validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if ($('#password').val() != $('#passwordRepeat').val()) {
                    alert('Password stimmt nicht überein.');
                    $('#password').addClass('is-invalid');
                    $('#passwordRepeat').addClass('is-invalid');
                    event.preventDefault();
                    event.stopPropagation();
                } else if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
