$('#addBtn').click(function() {
    var id = $(this).data('id');
    var Name = $('#employeeName').val();
    var Email = $('#employeeEmail').val();
    var Address = $('#employeeAddress').val();
    var Birthday = $('#employeeBirthday').val();
    var Phone = $('#employeePhone').val();
    var Position = $('#employeePosition').val();
    var changepassword = $('#employeePassword').val();
    
    var mode = $(this).text();


    if(mode=="Add" || mode =="Update")
    {
        if (Name && Email && Address && Birthday && Phone && Position) {
            // Create FormData object to send file and other data
            var formData = new FormData();
            formData.append("Name", Name);
            formData.append("Email", Email);
            formData.append("Address", Address);
            formData.append("Birthday", Birthday);
            formData.append("Phone", Phone);
            formData.append("Position", Position);
            formData.append("Type", mode);
            formData.append("id", id);
            formData.append("id", id);
            formData.append("changepassword", changepassword);
            
            // Show the loading spinner
            $('#loadingSpinner').show();
    
            // Send AJAX request
            $.ajax({
                url: "controller/employee.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#loadingSpinner').hide(); // Hide spinner after receiving response
                    var response = $.trim(response);
                    if (response == "User added successfully!") {
                        Swal.fire({
                            title: '<span style="color: green; font-size: 30px;">Great!</span>',
                            icon: "success",
                            html: '<span style="font-size: 25px; font-weight: 400;">User successfully added</span><br><br>',
                            width: 500,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: `<span style="font-size: 17px; ">Ok</span>`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(true);
                            }
                        });
                    }
                    else if (response == "User Duplicated Email!") {
                        Swal.fire({
                            title: '<span style="color: red; font-size: 30px;">Error!</span>',
                            icon: "error",
                            html: '<span style="font-size: 25px; font-weight: 400;">Email is already acquired</span><br><br>',
                            width: 500,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: `<span style="font-size: 17px; ">Ok</span>`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(true);
                            }
                        });
                        
                    }else if (response == "User Edited successfully!") {
                        Swal.fire({
                            title: '<span style="color: green; font-size: 30px;">Great!</span>',
                            icon: "success",
                            html: '<span style="font-size: 25px; font-weight: 400;">User successfully edited</span><br><br>',
                            width: 500,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: `<span style="font-size: 17px; ">Ok</span>`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(true);
                            }
                        });
                    }
                    
                    else {
                        console.error(response);
                        Swal.fire({
                            title: "Oops..!",
                            text: "Error occurred while processing your request.",
                            icon: "info"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $('#loadingSpinner').hide(); // Hide spinner on error
                    console.error(error);
                    Swal.fire({
                        title: "Oops..!",
                        text: "Error occurred while processing your request.",
                        icon: "info"
                    });
                },
                complete: function() {
                    $('#loadingSpinner').hide(); // Ensure spinner is hidden after request completes
                }
            });
        } else {
            Swal.fire({
                title: "Oops..!",
                text: "Please complete all required fields.",
                icon: "info"
            });
        }
    }else{
       if(mode=="Delete")
       {
        Swal.fire({
            title: "Are you sure you want to Delete?",
            showCancelButton: true,
            confirmButtonText: "Yes",
          }).then((result) => {

            
            var formData = new FormData();
            formData.append("id", id);
            formData.append("Type", mode);


            $('#loadingSpinner').show();
    
            // Send AJAX request
            $.ajax({
                url: "controller/employee.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#loadingSpinner').hide(); // Hide spinner after receiving response
                    var response = $.trim(response);
                    if (response == "User Deleted successfully!") {
                        Swal.fire({
                            title: '<span style="color: green; font-size: 30px;">Great!</span>',
                            icon: "success",
                            html: '<span style="font-size: 25px; font-weight: 400;">User successfully deleted</span><br><br>',
                            width: 500,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: `<span style="font-size: 17px; ">Ok</span>`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(true);
                            }
                        });
                    } else {
                        console.error(response);
                        Swal.fire({
                            title: "Oops..!",
                            text: "Error occurred while processing your request.",
                            icon: "info"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $('#loadingSpinner').hide(); // Hide spinner on error
                    console.error(error);
                    Swal.fire({
                        title: "Oops..!",
                        text: "Error occurred while processing your request.",
                        icon: "info"
                    });
                },
                complete: function() {
                    $('#loadingSpinner').hide(); // Ensure spinner is hidden after request completes
                }
            });
          });
       }else if(mode=="Restore")
       {
        Swal.fire({
            title: "Are you sure you want to Restore?",
            showCancelButton: true,
            confirmButtonText: "Yes",
          }).then((result) => {

            
            var formData = new FormData();
            formData.append("id", id);
            formData.append("Type", mode);


            $('#loadingSpinner').show();
    
            // Send AJAX request
            $.ajax({
                url: "controller/employee.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#loadingSpinner').hide(); // Hide spinner after receiving response
                    var response = $.trim(response);
                    if (response == "User Restored successfully!") {
                        Swal.fire({
                            title: '<span style="color: green; font-size: 30px;">Great!</span>',
                            icon: "success",
                            html: '<span style="font-size: 25px; font-weight: 400;">User successfully restored</span><br><br>',
                            width: 500,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: `<span style="font-size: 17px; ">Ok</span>`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(true);
                            }
                        });
                    } else {
                        console.error(response);
                        Swal.fire({
                            title: "Oops..!",
                            text: "Error occurred while processing your request.",
                            icon: "info"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $('#loadingSpinner').hide(); // Hide spinner on error
                    console.error(error);
                    Swal.fire({
                        title: "Oops..!",
                        text: "Error occurred while processing your request.",
                        icon: "info"
                    });
                },
                complete: function() {
                    $('#loadingSpinner').hide(); // Ensure spinner is hidden after request completes
                }
            });
          });
       }
    }

   

    
});

