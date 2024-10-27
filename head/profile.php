<?php 
$fname = ucwords($db->getIdByColumnValue("user_details","user_id",$user_id,"fname")) ?? '';
$mname = ucwords($db->getIdByColumnValue("user_details","user_id",$user_id,"mname")) ?? '';
$lname = ucwords($db->getIdByColumnValue("user_details","user_id",$user_id,"lname")) ?? '';
$gender = ucwords($db->getIdByColumnValue("user_details","user_id",$user_id,"gender")) ?? '';
$address = ucwords($db->getIdByColumnValue("user_details","user_id",$user_id,"address")) ?? '';
$birthday = ucwords($db->getIdByColumnValue("user_details","user_id",$user_id,"birthday")) ?? '';
$phone = $db->getIdByColumnValue("user_details","user_id",$user_id,"phone") ?? '';
$profile_picture = $db->getIdByColumnValue("user_details","user_id",$user_id,"profile_picture") ?? '';
$profile_picture = !empty($profile_picture) ? '../profile/'.$profile_picture : 'img/undraw_profile.svg';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">My Profile</h1>

    <!-- Profile Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Profile Picture -->
                <div class="col-md-3 text-center">
                    <img id="profilePic" src="<?= htmlspecialchars($profile_picture, ENT_QUOTES, 'UTF-8') ?>" alt="Profile Picture" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                    <input type="file" id="fileInput" class="form-control-file d-none" accept="image/*">
                    <button class="btn btn-primary btn-sm d-none" id="changePicBtn">Change Picture</button>
                </div>
                <!-- Profile Details -->
                <div class="col-md-9">
                    <form id="profileForm" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="fname">First Name:</label>
                                <input type="text" value="<?= htmlspecialchars($fname, ENT_QUOTES, 'UTF-8') ?>" class="form-control" id="fname" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mname">Middle Name:</label>
                                <input type="text" value="<?= htmlspecialchars($mname, ENT_QUOTES, 'UTF-8') ?>" class="form-control" id="mname" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lname">Last Name:</label>
                                <input type="text" value="<?= htmlspecialchars($lname, ENT_QUOTES, 'UTF-8') ?>" class="form-control" id="lname" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="gender" class="form-control" disabled>
                                <option <?= $gender === 'Male' ? 'selected' : '' ?>>Male</option>
                                <option <?= $gender === 'Female' ? 'selected' : '' ?>>Female</option>
                                <option <?= $gender === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea class="form-control" id="address" rows="3" disabled><?= htmlspecialchars($address, ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="birthday">Birthday:</label>
                            <input type="date" value="<?= htmlspecialchars($birthday, ENT_QUOTES, 'UTF-8') ?>" class="form-control" id="birthday" disabled>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="text" value="<?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?>" class="form-control" id="phone" disabled>
                        </div>
                        <button class="btn btn-primary" type="button" id="editBtn">Edit Profile</button>
                        <button class="btn btn-success d-none" type="button" id="saveBtn">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End of Page Content -->

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const $editBtn = $('#editBtn');
    const $saveBtn = $('#saveBtn');
    const $changePicBtn = $('#changePicBtn');
    const $fileInput = $('#fileInput');
    const $profilePic = $('#profilePic');
    const $form = $('#profileForm');

    $editBtn.on('click', function() {
        // Enable all form elements and show the "Change Picture" button
        $form.find('input, select, textarea').prop('disabled', false);
        $changePicBtn.removeClass('d-none');
        $editBtn.addClass('d-none');
        $saveBtn.removeClass('d-none');
    });

    $saveBtn.on('click', function() {
        // Check for empty fields
        const fname = $('#fname').val().trim();
        const mname = $('#mname').val().trim();
        const lname = $('#lname').val().trim();
        const gender = $('#gender').val().trim();
        const address = $('#address').val().trim();
        const birthday = $('#birthday').val().trim();
        const phone = $('#phone').val().trim();

        if (!fname || !lname || !gender || !address || !birthday || !phone) {
            Swal.fire({
                title: 'Error!',
                text: 'Please fill in all required fields.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Stop form submission
        }

        const formData = new FormData();
        
        // Manually append form values
        formData.append('fname', fname);
        formData.append('mname', mname);
        formData.append('lname', lname);
        formData.append('gender', gender);
        formData.append('address', address);
        formData.append('birthday', birthday);
        formData.append('phone', phone);

        // Append the file if it exists
        const file = $fileInput[0].files[0];
        if (file) {
            formData.append('profilePic', file);
        }

        // Log formData contents for debugging
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        $.ajax({
            url: 'controller/edit_profile.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Profile updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                console.log(response); // Log response for debugging
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while updating the profile.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('An error occurred while updating the profile.');
                console.error(xhr.responseText); // Log error response for debugging
            }
        });

        // Disable form elements and hide the "Change Picture" button
        $form.find('input, select, textarea').prop('disabled', true);
        $changePicBtn.addClass('d-none');
        $saveBtn.addClass('d-none');
        $editBtn.removeClass('d-none');
    });

    $changePicBtn.on('click', function() {
        $fileInput.click(); // Trigger the file input click event to open file picker
    });

    $fileInput.on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $profilePic.attr('src', e.target.result); // Set the profile picture to the selected image
            }
            reader.readAsDataURL(file); // Convert the file to a data URL
        }
    });
});

</script>
