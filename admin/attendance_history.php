<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Attendance History</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">Attendance</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Sign in</th>
                        <th>Sign out</th>
                        <th>Hour Count</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php 
                    $rows = $db->getAllRowsFromTable('attendance');

                    if(count($rows)>0){
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $user_id = $row['user_id'];
                            $date_format = 'Y-m-d H:i:s'; // Change this if your date-time format is different
                            // Convert strings to DateTime objects
                            $sign_in = DateTime::createFromFormat($date_format, $row['sign_in']);
                            $formatted_sign_in = $sign_in->format('M j Y / g:i A');
                            $formatted_sign_out = "Currently Sign in";
                            if($row['sign_out']!="0000-00-00 00:00:00")
                            {
                                $sign_out = DateTime::createFromFormat($date_format, $row['sign_out']);
                                $formatted_sign_out = $sign_out->format('M j Y / g:i A');
                            }else{
                                $formatted_sign_out = "Currently Sign in";
                            }

                            $hour_count = $row['hour_count'];
                            $verify_status = ucwords($row['verify_status']);

                           $name = $db->getIdByColumnValue("user_details","user_id",$user_id,"fname").' '.$db->getIdByColumnValue("user_details","user_id",$user_id,"lname");
                            

                           
                            $data='
                                data-id="'.$id.'"
                            ';
                            
                            
                            echo '<tr>
                            <td data-id="'.$row['id'].'">'.$name.'</td>
                            <td data-sign_in="'.$row['sign_in'].'">'.$formatted_sign_in.'</td>
                            <td data-sign_out="'.$row['sign_out'].'">'.$formatted_sign_out.'</td>
                            <td>'.$hour_count.'</td>
                            <td>'.$verify_status.'</td>
                            <td>
                                <button class="btn btn-success">EDIT</button>
                            </td>
                        </tr>';
                        
                        }
                    }
                    ?>
                    
              
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Edit Attendance Modal -->
<div class="modal fade" id="editAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="editAttendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAttendanceModalLabel">Edit Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAttendanceForm">
                    <input type="hidden" id="attendanceId" name="attendance_id">
                    
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="editSignIn">Sign In</label>
                        <input type="datetime-local" class="form-control" id="editSignIn" name="sign_in">
                    </div>
                    
                    <div class="form-group">
                        <label for="editSignOut">Sign Out</label>
                        <input type="datetime-local" class="form-control" id="editSignOut" name="sign_out">
                    </div>
                    
                    <div class="form-group">
                        <label for="editHourCount">Hour Count</label>
                        <input type="text" class="form-control" id="editHourCount" name="hour_count" >
                    </div>
                    
                    <div class="form-group">
                        <label for="editStatus">Status</label>
                        <select class="form-control" id="editStatus" name="verify_status">
                            <option value="pending">Pending</option>
                            <option value="verified">Verify</option>
                            <option value="reject">Reject</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.4/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/r-3.0.2/datatables.min.css" rel="stylesheet">
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.4/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/r-3.0.2/datatables.min.js"></script><script src="js/alertmaker.js"></script>

<script>
    new DataTable('#dataTable', {
        responsive: true,
    layout: {
        topStart: {
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Attendance History',
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'


            ]
        }
    }
});
</script>


<script>
$(document).ready(function() {
    // Edit button click event
    $('#dataTable').on('click', '.btn-success', function() {
        var row = $(this).closest('tr');
        var attendanceId = row.find('td').eq(0).data('id'); // Assuming ID is in the first column
        var name = row.find('td').eq(0).text();
        var signIn = row.find('td').eq(1).data('sign_in');
        var signOut = row.find('td').eq(2).data('sign_out');
        var hourCount = row.find('td').eq(3).text();
        var status = row.find('td').eq(4).text().toLowerCase();

        $('#attendanceId').val(attendanceId);
        $('#editName').val(name);

        // Convert to datetime-local format (YYYY-MM-DDTHH:MM)
        if (signIn) {
            var formattedSignIn = signIn.replace(" ", "T").slice(0, 16);
            $('#editSignIn').val(formattedSignIn);
        }

        if (signOut && signOut !== "Currently Sign in") {
            var formattedSignOut = signOut.replace(" ", "T").slice(0, 16);
            $('#editSignOut').val(formattedSignOut);
        } else {
            $('#editSignOut').val(""); // Clear the input if sign-out is "Currently Sign in"
        }

        $('#editHourCount').val(hourCount);
        $('#editStatus').val(status);

        $('#editAttendanceModal').modal('show');
    });

    // Handle form submission
    $('#editAttendanceForm').submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'controller/edit_attendance.php', // Adjust the URL based on your setup
            data: formData,
            success: function(response) {
                handleResponse(response)
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the attendance.',
                });
            }
        });
    });
});

</script>

