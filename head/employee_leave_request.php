<!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Leave Request</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">Leave Request</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Type of Leave</th>
                        <th>Message</th>
                        <th>From Date</th>
                        <th>Until Date</th>
                        <th>Leave Day Count</th>
                        <th>Request Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                <?php 
                    $rows = $db->getAllRowsFromTableWhere("leave_request", [
                                "leave_request_status = 'pending'",
                                "head_id = ".$_SESSION['id'],
                            ]);

                    if(count($rows)>0){
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $user_id = $row['user_id'];
                            $employee_name = $db->getIdByColumnValue("user_details","user_id",$user_id,"fname").' '.$db->getIdByColumnValue("user_details","user_id",$user_id,"lname");
                            $reason = ucwords($row['reason']);
                            $type = ucwords($row['type']);
                            $date_from = ucwords($row['date_from']);
                            $date_until = $row['date_until'];
                            $leave_request_status = ucwords($row['leave_request_status']);
                            $leave_day_count = $row['leave_day_count'];

                            $data='
                                data-id="'.$id.'"
                            ';

                            if($leave_request_status=="Pending")
                            {
                                $action = '<button '.$data.' data-type="update" data-toggle="modal" data-target="#formModal" class="editBtn btn btn-success">Edit</button>
                                ';
                            }else{
                                $action ="";
                            }
                            
                           
                            echo '<tr>
                                <td>'.ucwords($employee_name).'</td>
                                <td>'.$type.'</td>
                                <td>'.$reason.'</td>
                                <td>'.$date_from.'</td>
                                <td>'.$date_until.'</td>
                                <td>'.$leave_day_count.'</td>
                                <td>'.$leave_request_status.'</td>
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


<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <p class="delete-alert" hidden>Are you sure you want to delete this request?</p>
            <form id="formSubmit" enctype="multipart/form-data">
                <input type="text" name="edit_id" id="edit_id" hidden>
                        <div class="form-group">
                            <label for="reason" class="font-weight-bold">Status</label>
                            <select name="status_request" id="status_request" class="form-control-file border p-2">
                                <option value="pending" disabled >Pending</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="addLeaveBtn" type="button">Add</button>
            </div>
            </form>

        </div>
    </div>
</div>


<script src="js/alertmaker.js"></script>
<link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.4/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/r-3.0.2/datatables.min.css" rel="stylesheet">
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.4/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/r-3.0.2/datatables.min.js"></script>
<script>
$('#dataTable').DataTable( {
    responsive: true
} );
</script>
<script>

</script>

<script>
    $(document).ready(function() {
    var today = new Date().toISOString().split('T')[0];

    // Set the minimum value for "Until Date" to today's date
    $('#date_until,#date_from').attr('min', today);

    $('#addLeaveBtn').click(function() {
        $('#formLabel').text('Add Leave Request');
        $('.delete-alert').attr('hidden',true);
        $('.form-group').show()

        var status_request = $('#status_request').val();

        var mode = $(this).text();
        $('#loadingSpinner').show();

        var formData = new FormData($('#formSubmit')[0]);
        formData.append('mode', mode);
        
        $.ajax({
            url: 'controller/leave_request.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#loadingSpinner').hide();
                handleResponse(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#loadingSpinner').hide();
                handleResponse('error');
                console.log(textStatus, errorThrown);
            }
        });
    });
});

</script>

<script>
    $(document).on('click', '.editBtn', function() {
        var edit_id = ($(this).data('id'))
        var mode = $(this).text();

        $('#addLeaveBtn').text("Confirm")
        $('#edit_id').val(edit_id)

     
        $('#formLabel').text('Change Status Leave Request');
        $('.delete-alert').attr('hidden',true)
        $('.form-group').show()

    });
</script>