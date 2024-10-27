<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Job Applicants</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">Job Applicants</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-nowrap">Name</th>
                        <th class="text-nowrap">Job Applied</th>
                        <th class="text-nowrap">Application status</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap">Birthday</th>
                        <th class="text-nowrap">Phone</th>
                        <th class="text-nowrap">Address</th>
                        <th class="text-nowrap">Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php 
                    $rows = $db->getAllApplicants(0);

                    if(count($rows)>0){
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $email = $row['email'];
                            $fname = ucwords($row['fname']);
                            $mname = ucwords($row['mname']);
                            $lname = ucwords($row['lname']);

                            $fullname = $fname.' '.$mname.' '.$lname;

                            $address = ucwords($row['address']);
                            $birthday = $row['birthday'];
                            $phone = $row['phone'];
                            $position = ucwords($row['position']);
                            $job_id = $row['job_id'];
                            $job_applications_id = $row['job_applications_id'];
                            $job_title = $db->getIdByColumnValue("job_posting","id",$job_id,"title");
                            $application_status = ($row['application_status']);

                            $data='
                                data-userid="'.$id.'"
                                data-applicationstatus="'.$application_status.'"
                                data-jobapplicationsid="'.$job_applications_id.'"
                            ';
                            
                            $action = '<button '.$data.' data-type="update" data-toggle="modal" data-target="#formModal" class="editBtn btn btn-success">Change Status</button>
                                        ';
                            echo '<tr>
                                <td class="text-nowrap">'.$fullname.'</td>
                                <td class="text-nowrap">'.$job_title.'</td>
                                <td class="text-nowrap">'.ucwords($application_status).'</td>
                                <td class="text-nowrap">'.$email.'</td>
                                <td class="text-nowrap">'.$birthday.'</td>
                                <td class="text-nowrap">'.$phone.'</td>
                                <td class="text-nowrap">'.$address.'</td>
                                <td class="text-nowrap">'.$action.'</td>
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
                <h5 class="modal-title" id="formLabel">Applicant Status</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="applicantForm">
                    <div class="form-group">
                        <label for="employeeName">Change Status</label>
                        <input type="text" name="applicant_id" id="applicant_id" hidden>
                        <input type="text" name="user_id" id="user_id" hidden>
                        <select name="statusSelect" class="form-control" id="statusSelect">
                            <option value="for review">For Review</option>
                            <option value="for interview">For Interview</option>
                            <option value="for requirements">For Requirements</option>
                            <option value="for processing">For Processing</option>
                            <option value="hired">Hired</option>
                            <option value="declined">Declined</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="employeeName">Message</label>
                        <textarea name="message" id="message" placeholder="Add Message (Optional)" class="form-control" ></textarea>                       
                    </div>
                    <div class="form-group hired">
                        <label for="Date_FROM">Hired Date</label>
                        <input type="date" class="form-control" id="date_from" name="date_from">                       
                    </div>
                    <div class="form-group hired">
                        <label for="Date_to">Hired Until (Optional)</label>
                        <input type="date" class="form-control" id="date_to" name="date_to">                       
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveApplicantBtn" type="button">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.4/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/r-3.0.2/datatables.min.css" rel="stylesheet">
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.4/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/r-3.0.2/datatables.min.js"></script>
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
                    title: 'Employee Details',
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
    $('.hired').hide();
    $('#statusSelect').change(function(){
        var status = $(this).val()
        if(status==="hired")
        {
            $('.hired').show();
        }else{
            $('.hired').hide();
        }
    })
</script>
<script>
   $('#dataTable').on('click', '.editBtn, .deleteBtn', function() {
    // Retrieve data attributes from clicked button
    var user_id = $(this).data('userid');
    var application_status = $(this).data('applicationstatus');
    var job_applications_id = $(this).data('jobapplicationsid');

    // Set the values in the modal
    $('#applicant_id').val(job_applications_id);
    $('#user_id').val(user_id);
    $('#statusSelect').val(application_status);  // Set the current status in the select dropdown
    
    // Handle Save Changes button click
    $('#saveApplicantBtn').off('click').on('click', function() {
        $('#saveApplicantBtn').attr('disabled',true)
        var applicant_id = $('#applicant_id').val();
        var user_id = $('#user_id').val();
        var status = $('#statusSelect').val();
        var message = $('#message').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        

        $('#loadingSpinner').show();

        $.ajax({
            url: 'controller/job_applicants.php', // Update this to your server script path
            type: 'POST',
            data: {
                applicant_id: applicant_id,
                user_id: user_id,
                message: message,
                date_from: date_from,
                date_to: date_to,
                status: status
            },
            success: function(response) {
                $('#saveApplicantBtn').attr('disabled',false)
                $('#loadingSpinner').hide();
               if(response=="Update failed")
               {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Update failed.',
                });
               }else if(response=="Update successful"){
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Updated successfully.',
                }).then(() => {
                    location.reload(); // Reload the page after closing the alert
                });
               }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Update failed.',
                });
               }
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('An error occurred:', error);
            }
        });
    });
});



</script>