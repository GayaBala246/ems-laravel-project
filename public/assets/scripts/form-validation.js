
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');

            Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    // Exclude no-validate fields from validation
                    var inputs = form.querySelectorAll('input, select, textarea');
                    inputs.forEach(function (input) {
                        if (input.classList.contains('no-validate')) {
                            input.removeAttribute('required'); // Remove 'required' from no-validate fields
                        }
                    });

                    // Check form validity
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

