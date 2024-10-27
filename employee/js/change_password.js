$(document).ready(function() {
    const togglePasswordVisibility = (inputId, iconContainerId) => {
        const $passwordInput = $(`#${inputId}`);
        const $toggleIconContainer = $(`#${iconContainerId}`);
        const $toggleIcon = $toggleIconContainer.find('i'); // Find the <i> element within the container

        if (!$passwordInput.length || !$toggleIcon.length) return; // Ensure elements are present

        let isPasswordVisible = false;

        $toggleIconContainer.on('click', function() {
            isPasswordVisible = !isPasswordVisible;
            $passwordInput.attr('type', isPasswordVisible ? 'text' : 'password');
            $toggleIcon.text(isPasswordVisible ? 'visibility_off' : 'visibility');
        });
    };

    togglePasswordVisibility('oldPasswordInput', 'toggleOldPassword');
    togglePasswordVisibility('newPasswordInput', 'toggleNewPassword');
    togglePasswordVisibility('confirmPasswordInput', 'toggleConfirmPassword');
});

document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const oldPassword = document.getElementById('oldPasswordInput').value;
    const newPassword = document.getElementById('newPasswordInput').value;
    const confirmPassword = document.getElementById('confirmPasswordInput').value;

    if (newPassword !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'New password and confirmation password do not match.',
        });
    } else {
        $('#loadingSpinner').show();
        // AJAX request to handle password change
        $.ajax({
            url: 'controller/changepassword.php',
            method: 'POST',
            data: {
                oldPassword: oldPassword,
                newPassword: newPassword,
            },
            success: function(response) {
                $('#loadingSpinner').hide();
                const res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Password Changed',
                            text: res.message,
                        }).then(() => {
                            location.reload(); // Reload the page after closing the alert
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error processing your request. Please try again.',
                    });
                }
            });
    }
});