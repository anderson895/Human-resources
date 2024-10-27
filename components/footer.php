 <!-- Chatbot Icon -->
 <div id="chatbot-icon" class="chatbot-icon">
    <img src="assets/chatbot.png" alt="Chatbot">
</div>

<!-- Chatbot Popup -->
<div id="chatbot-popup" class="chatbot-popup">
    <!-- Include your chatbot script or iframe here -->
    <iframe src="chat_bot.php" frameborder="0"></iframe>
</div>

<footer>
     
       

	<!-- JS here -->
	
		<!-- All JS Custom Plugins Link Here here -->
        <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
		<!-- Jquery, Popper, Bootstrap -->
		<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
	    <!-- Jquery Mobile Menu -->
        <script src="./assets/js/jquery.slicknav.min.js"></script>

		<!-- Jquery Slick , Owl-Carousel Range -->
        <script src="./assets/js/owl.carousel.min.js"></script>
        <script src="./assets/js/slick.min.js"></script>
        <script src="./assets/js/price_rangs.js"></script>
		<!-- One Page, Animated-HeadLin -->
        <script src="./assets/js/wow.min.js"></script>
		<script src="./assets/js/animated.headline.js"></script>
        <script src="./assets/js/jquery.magnific-popup.js"></script>

		<!-- Scrollup, nice-select, sticky -->
        <script src="./assets/js/jquery.scrollUp.min.js"></script>
        <script src="./assets/js/jquery.nice-select.min.js"></script>
		<script src="./assets/js/jquery.sticky.js"></script>
        
        <!-- contact js -->
        <script src="./assets/js/contact.js"></script>
        <script src="./assets/js/jquery.form.js"></script>
        <script src="./assets/js/jquery.validate.min.js"></script>
        <script src="./assets/js/mail-script.js"></script>
        <script src="./assets/js/jquery.ajaxchimp.min.js"></script>
        
		<!-- Jquery Plugins, main Jquery -->	
        <script src="./assets/js/plugins.js"></script>
        <script src="./assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="js/login.js"></script>

    </body>
</html>

<!-- CHAT BOT -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var chatbotIcon = document.getElementById('chatbot-icon');
    var chatbotPopup = document.getElementById('chatbot-popup');

    chatbotIcon.addEventListener('click', function () {
        if (chatbotPopup.style.display === 'none' || chatbotPopup.style.display === '') {
            chatbotPopup.style.display = 'block';
        } else {
            chatbotPopup.style.display = 'none';
        }
    });


    // Close chatbot when clicking outside the popup
    document.addEventListener('click', function (event) {
        if (chatbotPopup.style.display === 'block' && !chatbotPopup.contains(event.target) && !chatbotIcon.contains(event.target)) {
            chatbotPopup.style.display = 'none';
        }
    });
});

</script>

<!-- FORGOT PASSWORD -->
<script>
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

    togglePasswordVisibility('password_Login', 'toggleNewPassword');
});
</script>



<!-- <script>
    $('#forgot').click(function() {
        $('#staticBackdrop').hide()
        Swal.fire({
            title: "Forgot your password?",
            input: "email",
            inputLabel: "Your email address",
            inputPlaceholder: "Enter your email address",
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'Please enter your email address!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const email = result.value;
                
                // Show loading spinner
                Swal.fire({
                    title: 'Sending Email...',
                    text: 'Please wait while we send the verification email.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send the email via AJAX
                $.ajax({
                    url: 'php/changepassword.php', // Replace with your server endpoint
                    type: 'POST',
                    data: { email: email },
                    dataType: 'json',
                    success: function(response) {
                        Swal.close(); // Close the loading spinner

                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Email Sent!',
                                text: response.message,
                            }).then(() => {
                                // Proceed to ask for verification code
                                Swal.fire({
                                    title: "Enter Verification Code",
                                    input: "text",
                                    inputLabel: "Verification Code",
                                    inputPlaceholder: "Enter the verification code sent to your email",
                                    html: `
                                        <p>If you don't see the email in your inbox, please check your spam folder and mark it as 'Not Spam' to ensure future emails are delivered to your inbox.</p>
                                    `,
                                    showCancelButton: true,
                                    inputValidator: (value) => {
                                        if (!value) {
                                            return 'Please enter the verification code!';
                                        }
                                    }
                                }).then((codeResult) => {
                                    if (codeResult.isConfirmed) {
                                        const verificationCode = codeResult.value;

                                        // Proceed to ask for new password
                                        Swal.fire({
                                            title: "Set New Password",
                                            html: `
                                                <input type="password" id="newPassword" class="swal2-input" placeholder="New Password">
                                                <input type="password" id="confirmPassword" class="swal2-input" placeholder="Confirm New Password">
                                            `,
                                            focusConfirm: false,
                                            preConfirm: () => {
                                                const newPassword = Swal.getPopup().querySelector('#newPassword').value;
                                                const confirmPassword = Swal.getPopup().querySelector('#confirmPassword').value;

                                                if (!newPassword || !confirmPassword) {
                                                    Swal.showValidationMessage('Please enter both password fields');
                                                    return false;
                                                }

                                                if (newPassword !== confirmPassword) {
                                                    Swal.showValidationMessage('Passwords do not match');
                                                    return false;
                                                }

                                                return {
                                                    verificationCode: verificationCode,
                                                    newPassword: newPassword
                                                };
                                            },
                                            showCancelButton: true
                                        }).then((passwordResult) => {
                                            if (passwordResult.isConfirmed) {
                                                const { verificationCode, newPassword } = passwordResult.value;
                                                
                                                // Show loading spinner
                                                Swal.fire({
                                                    title: 'Resetting Password...',
                                                    text: 'Please wait while we reset your password.',
                                                    allowOutsideClick: false,
                                                    didOpen: () => {
                                                        Swal.showLoading();
                                                    }
                                                });

                                                // Send the verification code and new password via AJAX
                                                $.ajax({
                                                    url: 'php/resetpassword.php', // Replace with your server endpoint
                                                    type: 'POST',
                                                    data: {
                                                        email: email,
                                                        verification_code: verificationCode,
                                                        new_password: newPassword
                                                    },
                                                    dataType: 'json',
                                                    success: function(response) {
                                                        Swal.close(); // Close the loading spinner
                                                        // Handle success response
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Password Changed Successfully',
                                                            text: 'Your password has been updated.',
                                                        }).then(() => {
                                                            location.reload(); // Reload the page after success
                                                        });
                                                    },
                                                    error: function(xhr, status, error) {
                                                        Swal.close(); // Close the loading spinner
                                                        // Handle error response
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: 'Something went wrong! Please try again later.',
                                                        }).then(() => {
                                                            location.reload(); // Reload the page after success
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            });
                        } else {
                            // Email not found or other errors
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            }).then(() => {
                            location.reload(); // Reload the page after success
                        });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close(); // Close the loading spinner
                        // Handle error response
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.',
                        }).then(() => {
                        location.reload(); // Reload the page after success
                    });
                    }
                });
            }
        });
    });
</script> -->

<script>
    $('#forgot').click(function() {
        $('#staticBackdrop').hide()
        Swal.fire({
            title: "Forgot your password?",
            input: "email",
            inputLabel: "Your email address",
            inputPlaceholder: "Enter your email address",
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'Please enter your email address!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const email = result.value;
                
                // Show loading spinner
                Swal.fire({
                    title: 'Sending Email...',
                    text: 'Please wait while we send the verification email.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send the email via AJAX
                $.ajax({
                    url: 'php/changepassword.php', // Replace with your server endpoint
                    type: 'POST',
                    data: { email: email },
                    dataType: 'json',
                    success: function(response) {
                        Swal.close(); // Close the loading spinner

                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: response.title,
                                text: response.message,
                            }).then(() => {
                                // Proceed to ask for verification code
                                Swal.fire({
                                    title: "Enter Verification Code",
                                    input: "text",
                                    inputLabel: "Verification Code",
                                    inputPlaceholder: "Enter the verification code sent to your email",
                                    html: `
                                        <p>If you don't see the email in your inbox, please check your spam folder and mark it as 'Not Spam' to ensure future emails are delivered to your inbox.</p>
                                    `,
                                    showCancelButton: true,
                                    inputValidator: (value) => {
                                        if (!value) {
                                            return 'Please enter the verification code!';
                                        }
                                    }
                                }).then((codeResult) => {
                                    if (codeResult.isConfirmed) {
                                        const verificationCode = codeResult.value;

                                        // Proceed to ask for new password
                                        Swal.fire({
                                            title: "Set New Password",
                                            html: `
                                                <input type="password" id="newPassword" class="swal2-input" placeholder="New Password">
                                                <input type="password" id="confirmPassword" class="swal2-input" placeholder="Confirm New Password">
                                            `,
                                            focusConfirm: false,
                                            preConfirm: () => {
                                                const newPassword = Swal.getPopup().querySelector('#newPassword').value;
                                                const confirmPassword = Swal.getPopup().querySelector('#confirmPassword').value;

                                                if (!newPassword || !confirmPassword) {
                                                    Swal.showValidationMessage('Please enter both password fields');
                                                    return false;
                                                }

                                                if (newPassword !== confirmPassword) {
                                                    Swal.showValidationMessage('Passwords do not match');
                                                    return false;
                                                }

                                                return {
                                                    verificationCode: verificationCode,
                                                    newPassword: newPassword
                                                };
                                            },
                                            showCancelButton: true
                                        }).then((passwordResult) => {
                                            if (passwordResult.isConfirmed) {
                                                const { verificationCode, newPassword } = passwordResult.value;
                                                
                                                // Show loading spinner
                                                Swal.fire({
                                                    title: 'Resetting Password...',
                                                    text: 'Please wait while we reset your password.',
                                                    allowOutsideClick: false,
                                                    didOpen: () => {
                                                        Swal.showLoading();
                                                    }
                                                });

                                                // Send the verification code and new password via AJAX
                                                $.ajax({
                                                    url: 'php/resetpassword.php', // Replace with your server endpoint
                                                    type: 'POST',
                                                    data: {
                                                        email: email,
                                                        verification_code: verificationCode,
                                                        new_password: newPassword
                                                    },
                                                    dataType: 'json',
                                                    success: function(response) {
                                                        Swal.close(); // Close the loading spinner
                                                        // Handle success response
                                                        Swal.fire({
                                                            icon: response.status,
                                                            title: response.title,
                                                            text: response.message,
                                                        }).then(() => {
                                                            if (response.status === 'success') {
                                                                location.reload(); // Reload the page after success
                                                            }else{
                                                                location.reload(); // Reload the page after success
                                                            }
                                                        });
                                                    },
                                                    error: function(xhr, status, error) {
                                                        Swal.close(); // Close the loading spinner
                                                        // Handle error response
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: 'Something went wrong! Please try again later.',
                                                        }).then(() => {
                                                                location.reload(); // Reload the page after success
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            });
                        } else {
                            // Email not found or other errors
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close(); // Close the loading spinner
                        // Handle error response
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.',
                        });
                    }
                });
            }
        });
    });
</script>
