document.addEventListener('DOMContentLoaded', function() {
    const noJobAlert = document.getElementById('nojobalert');
    const checkboxes = document.querySelectorAll('.select-Categories input[type="checkbox"]');
    const jobItems = document.querySelectorAll('.single-job-items');

    function filterJobs() {
        const selectedTypes = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.id);
        
        let anyJobVisible = false;

        jobItems.forEach(item => {
            const itemType = item.getAttribute('data-position');
            if (selectedTypes.length === 0 || selectedTypes.includes(itemType)) {
                item.style.display = 'block';
                anyJobVisible = true;
            } else {
                item.style.display = 'none';
            }
        });

        // Show or hide the no job alert based on visibility of job items
        if (anyJobVisible) {
            noJobAlert.style.display = 'none';
        } else {
            noJobAlert.style.display = 'block';
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterJobs);
    });

    // Initial filter application
    filterJobs();
});

$('.jobBtn').click(function(){
    $('#application_id').val($(this).data('id'))
})

$(document).ready(function() {
    var isSubmitting = false;

    // Listen for changes on form fields and remove is-invalid class if not empty
    $('#jobForm input, #jobForm select, #jobForm textarea').on('change', function() {
        if ($(this).val() !== '') {
            $(this).removeClass('is-invalid'); // Remove the class if the field is filled
        }
    });

    $('#submitApplication').click(function(e) {
        e.preventDefault(); // Prevent the default form submission
    
        // Validation: Check if all required fields are filled
        var isValid = true;
        $('#jobForm input, #jobForm select, #jobForm textarea').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid'); // Add a class to highlight the empty fields
            } else {
                $(this).removeClass('is-invalid'); // Remove the invalid class if the field is filled
            }
        });
    
        if (!isValid) {
            $('#spinner').addClass('d-none'); // Hide spinner
            // Show an alert or notification to the user
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Form',
                text: 'Please fill out all required fields before submitting.',
                confirmButtonText: 'OK'
            });
            return; // Exit if the form is not valid
        }
    
        if (isSubmitting) return; // Prevent multiple submissions
    
        isSubmitting = true; // Set flag to true to prevent further submissions
        $('#spinner').removeClass('d-none'); // Show spinner
        $(this).prop('disabled', true); // Disable the submit button
    
        // Serialize form data
        var formData = new FormData($('#jobForm')[0]);
    
        // Perform AJAX request
        $.ajax({
            url: 'php/find_job.php', // Replace with the path to your server-side script
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from automatically processing the data
            contentType: false, // Prevent jQuery from overriding the content type
            success: function(response) {
                // Handle the success response
                console.log('Application submitted successfully:', response);
                if (response == "User added successfully!") {
                    // SweetAlert2 success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Application Submitted',
                        text: 'Your application has been submitted successfully!',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        location.reload(); // Reload the page after closing the alert
                    });
                } else if (response == "The email address is not valid.") {
                    $('#spinner').addClass('d-none'); // Hide spinner
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Email address',
                        text: 'The email address is not valid.',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $('#spinner').addClass('d-none'); // Hide spinner
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                $('#spinner').addClass('d-none'); // Hide spinner
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during submission. Please try again later.',
                    confirmButtonText: 'OK'
                });
            },
            complete: function() {
                // Always executed
                $('#spinner').addClass('d-none'); // Hide spinner
                $('#submitApplication').prop('disabled', false); // Re-enable the submit button
                isSubmitting = false; // Reset flag
            }
        });
    });
    
});