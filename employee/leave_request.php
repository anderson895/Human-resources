<?php 
$employee_id = $_SESSION['id'];

// Initialize button as empty
$request = '<button class="btn btn-primary my-1 addBtn" data-toggle="modal" data-target="#formModal">Add Leave Request</button>';

// Check if there are pending requests
$pendingRequests = $db->getAllRowsFromTableWhere("leave_request", [
    "user_id = '".$employee_id."'",
    "leave_request_status = 'pending'"
]);

// Check if leave credit is not fully used
$acceptedRequests = $db->getAllRowsFromTableWhere("leave_request", [
    "user_id = '".$employee_id."'",
    "leave_request_status = 'accepted'"
]);

if (count($pendingRequests) > 0 || (count($acceptedRequests) > 0 && ($leave_credits - $db->getTotalLeaveCurrentYear($employee_id)) <= 0)) {
    $request = "";
}

$whereClause = 
[
    'role="head"',
];
$head_rows = ($db->getAllRowsFromTableWhere("users",$whereClause));
?>
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Leave Request</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">Leave Request</h6>
        <?=$request?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Type of Leave</th>
                        <th>Message</th>
                        <th>From Date</th>
                        <th>Until Date</th>
                        <th>Leave Day Count</th>
                        <th>Request Status</th>
                        <th>Head Department</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                <?php 
                    $rows = $db->getAllRowsFromTableWhere("leave_request", [
                                "user_id = '".$employee_id."'",
                            ]);

                    if(count($rows)>0){
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $reason = ucwords($row['reason']);
                            $type = ucwords($row['type']);
                            $date_from = ucwords($row['date_from']);
                            $date_until = $row['date_until'];
                            $leave_request_status = ucwords($row['leave_request_status']);
                            $leave_day_count = $row['leave_day_count'];
                            $head_id = $row['head_id'];

                            $head_name = $db->getIdByColumnValue("user_details","user_id",$head_id,"fname").' '.$db->getIdByColumnValue("user_details","user_id",$head_id,"lname");
                            $data='
                                data-head_id="'.$head_id.'"
                                data-id="'.$id.'"
                                data-reason="'.$reason.'"
                                data-type="'.$type.'"
                                data-date_from="'.$date_from.'"
                                data-date_until="'.$date_until.'"
                            ';

                            if($leave_request_status=="Pending")
                            {
                                $action = '<button '.$data.' data-type="update" data-toggle="modal" data-target="#formModal" class="editBtn btn btn-success">Edit</button>
                                <button '.$data.' data-type="delete" data-toggle="modal" data-target="#formModal" class="deleteBtn btn btn-danger">Delete</button>
                                ';
                            }else{
                                $action ="";
                            }
                            
                           
                            echo '<tr>
                                <td>'.$type.'</td>
                                <td>'.$reason.'</td>
                                <td>'.$date_from.'</td>
                                <td>'.$date_until.'</td>
                                <td>'.$leave_day_count.'</td>
                                <td>'.$leave_request_status.'</td>
                                <td>'.ucwords($head_name).'</td>
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
                    <label for="reason" class="font-weight-bold  ">Head Department</label>
                    <select id="head_id" name="head_id" class="form-control">
                        <option value="">Select Head Department</option>
                        <?php 
                        foreach ($head_rows as $row) {
                            $id = $row['id'];
                            $name = $db->getIdByColumnValue("user_details","user_id",$id,"fname").' '.$db->getIdByColumnValue("user_details","user_id",$id,"lname");

                            $sel_head = $selected ==$id ? 'selected' : '';
                            echo '<option '.$sel_head.' value="'.$id.'">'.ucwords($name).'</option>';
                        }
                        ?>
                    </select>
                </div>
               


                    <div class="form-group">
                            <label for="reason" class="font-weight-bold  ">Type of Leave</label>
                            <select name="type" class="form-control-file border p-2" id="type">
                            <option value="">Select Type</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Maternity Leave">Maternity Leave</option>
                            <option value="Vacation Leave">Vacation Leave</option>
                            <option value="Personal Leave">Personal Leave</option>
                            <option value="Emergency Leave">Emergency Leave</option>
                            <option value="Bereavement Leave">Bereavement Leave</option>
                            <option value="Unpaid Leave">Unpaid Leave</option>
                            <option value="Study Leave">Study Leave</option>
                        </select>

                        </div>

                        <div class="form-group">
                            <label for="reason" class="font-weight-bold  ">Message</label>
                            <textarea name="reason" class="form-control-file border p-2" id="reason"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                    <label for="fileInput" class="font-weight-bold  ">From Date</label>
                                    <input type="date" name="date_from" class="form-control-file border p-2" id="date_from">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label for="fileInput" class="font-weight-bold  ">Until Date</label>
                                <input type="date" name="date_until" class="form-control-file border p-2" id="date_until">
                                </div>
                            </div>
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


$(document).on('click', '.addBtn', function() {
    $('#formLabel').text('Add Leave Request');
    $('#addLeaveBtn').text('Add').attr('data-id', '').removeClass('btn-danger btn-success').addClass("btn-primary");
    $('#formModal').find('input, textarea, select').val('');
    $('.delete-alert').attr('hidden',true)
    $('.form-group').attr('hidden',false)
});


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

        var fromDate = $('#date_from').val();
        var untilDate = $('#date_until').val();
        // Check if dates are valid
        if (!fromDate || !untilDate) {
            Swal.fire({
                icon: 'warning',
                title: 'Date',
                text: 'Please select both From Date and Until Date.',
            });
            return;
        }

        if (new Date(untilDate) < new Date(fromDate)) {
            Swal.fire({
                icon: 'warning',
                title: 'Date',
                text: 'Until Date cannot be earlier than From Date.',
            });
            return;
        }

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
    $(document).on('click', '.editBtn,.deleteBtn', function() {
        var edit_id = ($(this).data('id'))
        var type = ($(this).data('type'))
        var head_id = ($(this).data('head_id'))
        var reason = ($(this).data('reason'))
        var date_from = ($(this).data('date_from'))
        var date_until = ($(this).data('date_until'))
        var mode = $(this).text();
        
        $('#addLeaveBtn').text(mode)
        $('#edit_id').val(edit_id)
        $('#head_id').val(head_id)
        $('#type').val(type)
        $('#reason').val(reason)
        $('#date_from').val(date_from)
        $('#date_until').val(date_until)

        if(mode=="Delete")
    {
        $('#formLabel').text('Delete Leave Request');
        $('.delete-alert').attr('hidden',false)
        $('.form-group').hide()
    }else{
        $('#formLabel').text('Edit Leave Request');
        $('.delete-alert').attr('hidden',true)
        $('.form-group').show()
    }

    });
</script>