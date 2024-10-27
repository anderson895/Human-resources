<!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Manage Job Posting</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">Job Posting</h6>
        <button class="btn btn-primary my-1 addBtn" data-toggle="modal" data-target="#formModal">Post Job</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Job Title</th>
                        <th>Position</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                <?php 
                    $rows = $db->getAllRowsFromTable('job_posting');

                    if(count($rows) > 0) {
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $title = $row['title'];
                            $image = $row['image'];
                            $description = ucwords($row['description']);
                            $location = ucwords($row['location']);
                            $position = ucwords($row['position']);
                            
                            $data = '
                                data-id="'.$id.'"
                                data-title="'.$title.'"
                                data-description="'.$description.'"
                                data-location="'.$location.'"
                                data-position="'.$position.'"
                            ';
                            
                            $action = '<button '.$data.' data-type="update" data-toggle="modal" data-target="#formModal" class="editBtn btn btn-success">Edit</button>
                                    <button '.$data.' data-type="delete" data-toggle="modal" data-target="#formModal" class="deleteBtn btn btn-danger">Delete</button>';
                            
                            echo '<tr>
                                <td style="text-align: center;">
                                    <a href="uploads/job_posting/'.$image.'" data-lightbox="job-images" data-title="'.$title.'">
                                        <img width="100px" height="100px" src="uploads/job_posting/'.$image.'" alt="job image" style="object-fit: cover; border-radius: 5px; border: 1px solid #ccc;">
                                    </a>
                                </td>
                                <td>'.$title.'</td>
                                <td>'.$position.'</td>
                                <td>'.$description.'</td>
                                <td>'.$location.'</td>
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
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Add Job Posting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="jobPostingForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Job Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Job Title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" name="location" id="location" placeholder="Enter Location" required>
                    </div>
                    <div class="form-group">
                        <label for="position">Type of Employee</label>
                        <select name="position" id="position" class="form-control">
                            <option value="">Select Position</option>
                            <option value="Regular">Regular</option>
                            <option value="Contractual">Contractual</option>
                            <option value="Probi">Probi</option>
                            <option value="OJT">OJT</option>
                            <option value="Trainee">Trainee</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control-file" id="image" accept="image/*">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="addBtn">Add</button>
            </div>

        </div>
        </form>

    </div>
</div>
<!-- Add these in the head section of your HTML -->
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

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

        // Handle Edit and Delete button clicks
        $('.editBtn, .deleteBtn').click(function() {
            var button = $(this);
            var id = button.data('id');
            var title = button.data('title');
            var description = button.data('description');
            var location = button.data('location');
            var position = button.data('position');
            var type = button.data('type');
            $('#addBtn').attr('data-id', id); 
            $('#jobPostingForm').find('#title').val(title);
            $('#jobPostingForm').find('#description').val(description); 
            $('#jobPostingForm').find('#location').val(location); 
            $('#jobPostingForm').find('#position').val(position);
            if (type === 'update') {
                // Set form data for editing
                $('#formModalLabel').text('Edit Job Posting');
                $('#addBtn').text('Update').attr('data-id', id); 

            } else if (type === 'delete') {
                $('#formModalLabel').text('Delete Job Posting');
                $('#addBtn').text('Delete').attr('data-id', id); 
            }
        });

        $('#addBtn').click(function() {
            var mode = $(this).text();
            var edit_id = $(this).data('id');
            var formData = new FormData(document.getElementById('jobPostingForm')); 
            formData.append('mode', mode);
            formData.append('edit_id', edit_id);

            if (mode === "Delete") {
                // Show SweetAlert confirmation dialog
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
                        // Send AJAX request if confirmed
                        $.ajax({
                            url: "controller/job_posting.php",
                            type: "POST",
                            data: formData,
                            contentType: false, // Needed for FormData
                            processData: false, // Prevent jQuery from processing the data
                            success: function(response) {
                                handleResponse(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                });
            } else {
                // Send AJAX request for other modes (e.g., Add, Update)
                $.ajax({
                    url: "controller/job_posting.php",
                    type: "POST",
                    data: formData,
                    contentType: false, // Needed for FormData
                    processData: false, // Prevent jQuery from processing the data
                    success: function(response) {
                        handleResponse(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });


    });
</script>
