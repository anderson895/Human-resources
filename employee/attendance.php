<?php 
$user_id = $_SESSION['id'];
$where = 
[
    'user_id='.$user_id,
    'sign_out= "0000-00-00 00:00:00"',
];

$attendance_row = $db->getAllRowsFromTableWhere("attendance",$where);
$checker = count($attendance_row);

$whereClause = 
[
    'role="head"',
];
$rows = ($db->getAllRowsFromTableWhere("users",$whereClause));
$signInBtn = '';
$signOutBtn = '';
if($checker=="0")
{
   $selected =  $db->getIdByColumnValue("attendance","user_id",$user_id,"head_id");

    $selected = $selected!="" ? $selected : "";
    $signOutBtn = 'hidden';
}
if($checker=="1")
{
    $selected = $attendance_row[0]['head_id'];
    $signInBtn = 'hidden';
}
?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Attendance</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary my-1">Attendance</h6>
        </div>
        <div class="card-body">
            <div class="row text-center justify-content-center">
                <div class="col-md-4 my-2">
                    <select <?=$signInBtn?> id="head_Department" class="form-control">
                        <option value="">Select Head Department</option>
                        <?php 
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $name = $db->getIdByColumnValue("user_details","user_id",$id,"fname").' '.$db->getIdByColumnValue("user_details","user_id",$id,"lname");

                            $sel_head = $selected ==$id ? 'selected' : '';
                            echo '<option '.$sel_head.' value="'.$id.'">'.ucwords($name).'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-12 mb-4">
                    <button id="signInBtn" <?=$signInBtn?> class="btn px-4 py-4 btn-success btn-lg">Time in</button>
                </div>
                <div class="col-md-12 mb-4">
                    <button id="signOutBtn" <?=$signOutBtn?> class="btn px-4 py-4 btn-danger btn-lg">Time out</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Custom Script -->
<script src="js/alertmaker.js"></script>
<script>
    // Function to get current date and time in a readable format
    function getCurrentDateTime() {
        const now = new Date();
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        };
        return now.toLocaleDateString('en-US', options);
    }

    // AJAX function to send Time in/out data to the server
    function sendAttendanceData(actionType) {
        const currentDateTime = getCurrentDateTime();

        var head_Department = $('#head_Department').val();

        if(head_Department=="")
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please Select Head Department',
                            confirmButtonText: 'OK'
                        });

                        return;
            }

        $.ajax({
            url: 'controller/attendance.php',
            type: 'POST',
            data: {
                action: actionType,
                timestamp: currentDateTime,
                head_Department: head_Department
            },
            success: function(response) {
                // Assuming response is a success message or similar
                Swal.fire({
                    icon: 'success',
                    title: actionType === 'signIn' ? 'Signed In' : 'Signed Out',
                    html: `You have successfully ${actionType === 'signIn' ? 'signed in' : 'signed out'}.<br><strong>${currentDateTime}</strong>`,
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // Reload the page after alert
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    // Confirmation and Time in action
    document.getElementById('signInBtn').addEventListener('click', function() {
        Swal.fire({
            icon: 'question',
            title: 'Are you sure?',
            html: `Do you want to Time in?<br><strong>${getCurrentDateTime()}</strong>`,
            showCancelButton: true,
            confirmButtonText: 'Yes, Time in!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send Time in data via AJAX
                sendAttendanceData('signIn');
            }
        });
    });

    // Confirmation and Time out action
    document.getElementById('signOutBtn').addEventListener('click', function() {
        Swal.fire({
            icon: 'question',
            title: 'Are you sure?',
            html: `Do you want to Time out?<br><strong>${getCurrentDateTime()}</strong>`,
            showCancelButton: true,
            confirmButtonText: 'Yes, Time out!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send Time out data via AJAX
                sendAttendanceData('signOut');
            }
        });
    });
</script>
