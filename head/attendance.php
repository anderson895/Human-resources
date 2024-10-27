<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Manage Attendance</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary my-1">Attendance</h6>
            <!-- Add a "Verify All" button -->
            <button id="verifyAllBtn" class="btn btn-success">Verify Selected</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <!-- Add a "Select All" checkbox -->
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Name</th>
                            <th>Sign in</th>
                            <th>Sign out</th>
                            <th>Hour Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $where = [
                            'verify_status="pending"',
                            'head_id="'.$_SESSION['id'].'"' 
                        ];
                        $rows = $db->getAllRowsFromTableWhere('attendance',$where);

                        if(count($rows)>0){
                            foreach ($rows as $row) {
                                $id = $row['id'];
                                $user_id = $row['user_id'];
                                $hour_count = $row['hour_count'];
                                $verify_status = $row['verify_status'];
                                $sign_out = $row['sign_out'];

                               $name = $db->getIdByColumnValue("user_details","user_id",$user_id,"fname").' '.$db->getIdByColumnValue("user_details","user_id",$user_id,"lname");

                                $date_format = 'Y-m-d H:i:s'; // Change this if your date-time format is different
                                $sign_in = DateTime::createFromFormat($date_format, $row['sign_in']);
                                $formatted_sign_in = $sign_in->format('M j Y / g:i A');
                                $formatted_sign_out = "Currently Sign in";

                                if($sign_out != "0000-00-00 00:00:00") {
                                    $sign_out = DateTime::createFromFormat($date_format, $sign_out);
                                    $formatted_sign_out = $sign_out->format('M j Y / g:i A');
                                } else {
                                    $formatted_sign_out = "Currently Sign in";
                                }

                                $checkbox = $formatted_sign_out !== "Currently Sign in" ? 
                                    '<input type="checkbox" class="row-checkbox" data-id="'.$id.'">' : 
                                    ''; // Conditionally include checkbox

                                $action = '
                                    <button data-id="'.$id.'" data-type="verify" class="verifyBtn btn btn-success">Verify</button>
                                    <button data-id="'.$id.'" data-type="reject" class="rejectBtn btn btn-danger">Reject</button>
                                ';

                                if($formatted_sign_out === "Currently Sign in") {
                                    $action = '
                                        <button data-id="'.$id.'" data-type="reject" class="rejectBtn btn btn-danger">Reject</button>
                                    ';
                                }

                                echo '<tr>
                                    <td>'.$checkbox.'</td>
                                    <td>'.ucwords($name).'</td>
                                    <td>'.$formatted_sign_in.'</td>
                                    <td>'.$formatted_sign_out.'</td>
                                    <td>'.$hour_count.'</td>
                                    <td>'.$action.'</td>
                                </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.1.3/b-3.1.1/r-3.0.2/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.1.3/b-3.1.1/r-3.0.2/datatables.min.js"></script>
    <script src="js/alertmaker.js"></script>
    <script>
    $(document).ready(function() {
        // Initialize DataTable
        new DataTable('#dataTable');

        // Handle click event for Verify and Reject buttons
        $(document).on('click', '.verifyBtn, .rejectBtn', function() {
            const button = $(this);
            const id = button.data('id');
            const actionType = button.data('type');

            let title, text, confirmButtonText;

            if (actionType === 'verify') {
                title = 'Are you sure you want to verify?';
                text = "You won't be able to revert this!";
                confirmButtonText = 'Yes, verify it!';
            } else if (actionType === 'reject') {
                title = 'Are you sure you want to reject?';
                text = "You won't be able to revert this!";
                confirmButtonText = 'Yes, reject it!';
            }

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX request to verify or reject attendance
                    $.ajax({
                        url: 'controller/attendance.php', // Update with your actual PHP file path
                        type: 'POST',
                        data: {
                            action: actionType, // Pass action type
                            id: id
                        },
                        success: function(response) {
                            // Handle the response from the server
                            handleResponse(response);
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Something went wrong. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // Handle "Select All" checkbox change event
        $('#selectAll').change(function() {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Handle "Verify Selected" button click
        $('#verifyAllBtn').click(function() {
            const selectedIds = $('.row-checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length === 0) {
                Swal.fire(
                    'No Selection!',
                    'Please select at least one row to verify.',
                    'warning'
                );
                return;
            }

            Swal.fire({
                title: 'Are you sure you want to verify all selected?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, verify them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX request to verify all selected attendance
                    $.ajax({
                        url: 'controller/attendance.php', // Update with your actual PHP file path
                        type: 'POST',
                        data: {
                            action: 'verifyAll',
                            ids: selectedIds
                        },
                        success: function(response) {
                            // Handle the response from the server
                            handleResponse(response);
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Something went wrong. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
    </script>
</div>
