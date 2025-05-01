$(document).ready(function () {

    //create employee
    $('#create_emp').on('submit', function (e) {
        e.preventDefault();

        // Clear previous validation styles before submitting
        $('#create_emp .form-control').removeClass('is-invalid is-valid'); // Remove both success and error styles
        $('#create_emp .invalid-feedback').text(''); // Clear any previous error messages

        let formdata = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/employee/create',
            data: formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.success) {
                    alert(data.message);
                    window.location.href = '/employee/list'; // Redirect after success
                }
            },
            error: function (xhr) {
                // Clear previous success and error styles

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        let input = $(`[name="${field}"]`);
                        input.addClass('is-invalid'); // Add error (red) style
                        input.closest('.form-group').find('.invalid-feedback').text(messages[0]); // Display error message
                    });
                } else {
                    alert("Something went wrong!");
                }
            }
        });
    });

    // Input field validation handling (to clear invalid-feedback when valid)
$('.form-control').on('input', function () {
    let input = $(this);

    if (input.val() && input[0].checkValidity()) {
        // If input is valid
        input.removeClass('is-invalid').addClass('is-valid'); // Apply green border
        input.closest('.form-group').find('.invalid-feedback').text(''); // Clear the error message
    } else {
        // If input is invalid
        input.removeClass('is-valid'); // Remove green border
    }
});


    //create shift

      //create employee
      $('#create_shift').on('submit', function (e) {
        e.preventDefault();

        // Clear previous validation styles before submitting
        $('#create_shift .form-control').removeClass('is-invalid is-valid'); // Remove both success and error styles
        $('#create_shift .invalid-feedback').text(''); // Clear any previous error messages

        let formdata = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/shift/create',
            data: formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.success) {
                    alert(data.message);
                    window.location.href = '/shift/list'; // Redirect after success
                }else {
                    alert(data.message);
                }
            },
            error: function (xhr) {
                // Clear previous success and error styles

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        let input = $(`[name="${field}"]`);
                        input.addClass('is-invalid'); // Add error (red) style
                        input.closest('.form-group').find('.invalid-feedback').text(messages[0]); // Display error message
                    });
                } else {
                    alert("Something went wrong!");
                }
            }
        });
    });




    //create payroll
    $("#create_payroll").submit(function (e) {

        console.log(e)
        e.preventDefault();
        const formdata = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/payroll/create',
            data: formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: (data) => {
                console.log(data);
                if (data.success === true) {
                    alert(data.message.join("\n"));  // Fix: Join array into a readable string
                    window.location.href = '/payroll/list'; // Redirect after success
                }
                else {
                    alert(data.message);
                }
            },
            error: function (xhr) {
                // Clear previous success and error styles

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        let input = $(`[name="${field}"]`);
                        input.addClass('is-invalid'); // Add error (red) style
                        input.closest('.form-group').find('.invalid-feedback').text(messages[0]); // Display error message
                    });
                } else {
                    alert("Something went wrong!");
                }
            }
        })

    })

})
