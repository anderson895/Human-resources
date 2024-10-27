<!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Upload Documents</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">Upload Documents</h6>
        <button class="btn btn-primary my-1 addBtn" data-toggle="modal" data-target="#formModal">Add File</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>File Type</th>
                        <th>Note</th>
                        <th>File Uploaded</th>
                        <th>Uploaded on</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                   <?php 
                   $employee_id = $_SESSION['id'];
                   $where = [
                       "employee_id = '".$employee_id."'"
                   ];
                   $rows = $db->getAllRowsFromTableWhere("employee_files", $where);
                   
                   foreach ($rows as $row) {
                       $file = $row['file'];
                       $file_type = $row['file_type'];
                       
                       $description = $row['description'];
                       $datetime_created = $row['datetime_created'];
                       $employee_file_id = $row['id'];
                       $file_url = 'http://localhost/hris/admin/uploads/' . $file; // URL where files are accessible
                   


                       // Check if the file exists using cURL
                       $ch = curl_init($file_url);
                       curl_setopt($ch, CURLOPT_NOBODY, true);
                       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                       curl_exec($ch);
                       $file_exists = curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200;
                       curl_close($ch);
                   
                       // Get file size and type
                       $fileSize = $file_exists ? filesize('../admin/uploads/' . $file) : 'N/A';
                       $fileType = $file_exists ? mime_content_type('../admin/uploads/' . $file) : 'N/A';
                       $fileSizeFormatted = $fileSize !== 'N/A' ? round($fileSize / 1024, 2) . ' KB' : 'N/A';
                   
                       $data='
                       data-id="'.$employee_file_id.'"
                       data-file_type="'.$file_type.'"
                       data-description="'.$description.'"
                       ';


                        $added_by = $row['added_by'];
                        $action = $added_by =="employee" ? '
                         <td class="text-center">
                          <button type="button" '.$data.' class="btn btnEditFile btn-success btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" '.$data.' class="btn btnDeleteFile btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </td>
                        ' : '
                         <td class="text-center text-nowrap">Added by Admin</td>
                        ';




                       if ($file_exists) {
                           echo '<tr>
                                   <td>'.$file_type.'</td>
                                   <td>'.$description.'</td>
                                   <td>
                                       <a href="'.$file_url.'" title="Click to download" download="'.$file.'">'.$file.'</a>
                                       <br><small>Size: '.$fileSizeFormatted.' | Type: '.$fileType.'</small>
                                   </td>
                                    <td>'.$datetime_created.'</td>
                                  '.$action.'
                               </tr>';
                       } else {
                           echo '<tr>
                                   <td>'.$description.'</td>
                                   <td>File not available</td>
                                   <td class="text-center">
                                       <button class="btn btn-danger btn-sm">
                                           <i class="fas fa-trash-alt"></i> Delete
                                       </button>
                                   </td>
                                   <td>'.$datetime_created.'</td>
                                    '.$action.'
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
                <h5 class="modal-title" id="formLabel">Add File</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="delete-alert">Are you sure you want to delete this file?</p>
            <form id="formSubmit" enctype="multipart/form-data">
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
                            <label for="fileInput" class="font-weight-bold  ">Note</label>
                            <textarea name="description" class="form-control-file border p-2" id="Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fileInput" class="font-weight-bold">File</label>
                            <input type="file" name="file" class="form-control-file border p-2" id="fileInput">
                        </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="addFileBtn" type="button">Add</button>
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
    $(document).ready(function() {
        $('#addFileBtn').click(function() {
           
          var mode = $(this).text();
          var fileId = $(this).data('id');
          
            // Show the loading spinner
            $('#loadingSpinner').show();

            // Create a FormData object
            var formData = new FormData($('#formSubmit')[0]);
            formData.append('mode', mode);
            formData.append('fileId', fileId);
            
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

<script>
    $(document).ready(function() {

// Edit button click event
$(document).on('click', '.btnEditFile', function() {
    var fileId = $(this).data('id');
    var description = $(this).data('description');
    var file_type = $(this).data('file_type');


    $('#formSubmit #Description').val(description)
    $('#formSubmit #file_type').val(file_type)
    $('#formModal').modal('show');
    $('#formLabel').text('Edit File');
    $('#addFileBtn').text('Update').attr('data-id', fileId).removeClass('btn-primary btn-danger').addClass("btn-success");
       
    $('.delete-alert').attr('hidden',true)
    $('.form-group').attr('hidden',false)
});

// Delete button click event
$(document).on('click', '.btnDeleteFile', function() {
    var fileId = $(this).data('id');
    $('#formModal').modal('show');
    $('.delete-alert').attr('hidden',false)
    $('.form-group').attr('hidden',true)
    $('#formLabel').text('Delete File');
    $('#addFileBtn').text('Delete').attr('data-id', fileId).removeClass('btn-primary btn-success').addClass("btn-danger");

});

$(document).on('click', '.addBtn', function() {
    $('#formLabel').text('Add File');
    $('#addFileBtn').text('Add').attr('data-id', '').removeClass('btn-danger btn-success').addClass("btn-primary");
    $('#formModal').find('input, textarea, select').val('');
    $('.delete-alert').attr('hidden',true)
    $('.form-group').attr('hidden',false)
});

});

</script>