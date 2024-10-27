<!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Manage Applicant Files</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">Applicant Files</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Application Status</th>
                        <th>Email</th>
                        <th>Birthday</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
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
                                data-id="'.$id.'"
                                data-email="'.$email.'"
                                data-address="'.$address.'"
                                data-birthday="'.$birthday.'"
                                data-phone="'.$phone.'"
                                data-position="'.$position.'"
                            ';
                            
                            $action = '<button '.$data.' data-type="view" data-toggle="modal" data-target="#formModal" class="viewBtn btn btn-success">View</button>
                                        ';
                            echo '<tr>
                                <td>'.$fullname.'</td>
                                <td>'.$application_status.'</td>
                                <td>'.$email.'</td>
                                <td>'.$birthday.'</td>
                                <td>'.$phone.'</td>
                                <td>'.$address.'</td>
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


<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="formLabel">View Employee Files</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formSubmit" enctype="multipart/form-data">
                   <div class="row justify-content-center">
                    <div class="col-sm-6  border border-2 my-2 py-3 rounded ">
                        <div class="form-group">
                            <label for="fileInput" class="font-weight-bold  ">File Type</label>
                            <select name="file_type" class="form-control-file border p-2" id="file_type">
                                <option value="">Select Type</option>
                                <option value="Resume/CV">Resume/CV</option>
                                <option value="SSS">SSS</option>
                                <option value="Police Clearance">Police Clearance</option>
                                <option value="Passport">Passport</option>
                                <option value="Birth Certificate">Birth Certificate</option>
                                <option value="Driver's License">Driver's License</option>
                                <option value="NBI Clearance">NBI Clearance</option>
                                <option value="Barangay Clearance">Barangay Clearance</option>
                                <option value="Voter's ID">Voter's ID</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="employee_id" id="employee_id" hidden>
                            <label for="fileInput" class="font-weight-bold  ">Add Note</label>
                            <input type="text" name="description" class="form-control-file border p-2" id="Description">
                        </div>
                        <div class="form-group">
                            <label for="fileInput" class="font-weight-bold">Add File</label>
                            <input type="file" name="file" class="form-control-file border p-2" id="fileInput">
                        </div>

                        <button class="btn btn-success float-right" id="addFileBtn" type="button">
                        <i class="fas fa-plus"></i> Add File
                    </button>
                    </div>

                  
                   </div>

                   

                 

                </form>

                    <div class="table-responsive">
                    <table class="table table-hover w-full">
                        <thead class="thead-light">
                            <tr>
                                <th>File Type</th>
                                <th>File Name</th>
                                <th>Note</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="fileList">
                            <tr>
                                <td>File 1</td>
                                <td>File 1</td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <!-- Additional rows can be added here dynamically -->
                        </tbody>
                    </table>
                    </div>
            </div>
        </div>
    </div>
</div>




<script src="js/employee.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">
<script>
    new DataTable('#dataTable');
</script>
<script>
    $(document).ready(function() {
        $('.viewBtn').click(function() {
            $('#loadingSpinner').show();
            var id = $(this).data('id');
            $('#employee_id').val(id);

            $.ajax({
                url: 'controller/get_employee_files.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    // Assuming response is HTML
                    $('#fileList').html(response); // Insert the HTML into a container
                    $('#loadingSpinner').hide();
                    $('.btnDeleteFile').click(function(){
                        var fileId = $(this).data('id').toString();
                        
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#loadingSpinner').show();
                                // Perform the delete action here
                                console.log('Deleting file with ID:', fileId);
                                // Ajax request
                                $.ajax({
                                    url: 'controller/employee_files.php',  // Replace with your server-side script
                                    type: 'POST',
                                    data: {fileId:fileId},
                                    success: function(response) {
                                        // Hide the loading spinner
                                        $('#loadingSpinner').hide();

                                        // Call the function to handle the response
                                        handleResponse(response);
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        // Hide the loading spinner
                                        $('#loadingSpinner').hide();

                                        // Call the function to handle the error
                                        handleResponse('error');
                                        console.log(textStatus, errorThrown);
                                    }
                                });
                            }
                        });
                    });

                    // If you want to handle errors or empty responses
                    if (!response.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Files Found',
                            text: 'No files were found for the selected employee.',
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#loadingSpinner').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'AJAX Error',
                        text: 'An error occurred while retrieving the data.',
                    });
                    console.log(textStatus, errorThrown);
                }
            });

            
        });
    });
</script>

</script>
<script src="js/alertmaker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#addFileBtn').click(function() {
            // Show the loading spinner
            $('#loadingSpinner').show();

            // Create a FormData object
            var formData = new FormData($('#formSubmit')[0]);

            // Ajax request
            $.ajax({
                url: 'controller/employee_files.php',  // Replace with your server-side script
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Hide the loading spinner
                    $('#loadingSpinner').hide();

                    // Call the function to handle the response
                    handleResponse(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Hide the loading spinner
                    $('#loadingSpinner').hide();

                    // Call the function to handle the error
                    handleResponse('error');
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });

   
</script>
