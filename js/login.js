// Bind the click event to the login button

$("#staticBackdrop .loginBtn").click(function(event) {
  console.log(1)
  // Prevent the default form submission
  event.preventDefault();

  // Get the form data
  var formData = $("#loginForm").serialize();

  // Send an Ajax POST request
  $.ajax({
      type: "POST",
      url: "php/login.php", // Replace with your server-side script
      data: formData,
      success: function(response) {
          if (response === '200') {
              console.log(response);
              // Show a success SweetAlert
              Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: 'Login successful!',
              }).then(function() {
                  // Redirect to index.php
                  window.location.href = 'routes.php';
              });
          }
          else if(response=="Invalid email format")
            {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Invalid Email Format!',
              });
            } 
            else if(response=="Password cannot be empty")
              {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Password cannot be empty!',
              });
              } 
            else {
              // Show an error SweetAlert
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Invalid Credentials',
              });
          }
      },
      error: function() {
          // Handle errors
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred during the login process.',
          });
      }
  });
});
