<!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Accounts History</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">Accounts History</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Email</th>
                        <th>Birthday</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php 
                    $rows = $db->getAllEmployee(1);

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

                            $data='
                                data-id="'.$id.'"
                                data-email="'.$email.'"
                                data-name="'.$name.'"
                                data-address="'.$address.'"
                                data-birthday="'.$birthday.'"
                                data-phone="'.$phone.'"
                                data-position="'.$position.'"
                            ';
                            
                            $action = '
                                        <button '.$data.' data-type="delete" data-toggle="modal" data-target="#formModal" class="deleteBtn btn btn-warning">Restore</button>
                                        ';
                            echo '<tr>
                                <td>'.ucwords($name).'</td>
                                <td>'.$position.'</td>
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


<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formLabel">Add Employee</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        Are you sure you want to restore this Employee?
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="addBtn" type="button">Add</button>
            </div>
        </div>
    </div>
</div>


<script src="js/employee.js"></script>
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

    $('.deleteBtn').click(function() {
        // Retrieve data attributes from clicked button
        var id = $(this).data('id');
        var type = $(this).text();
        console.log(type)
        if(type==="Restore")
        {
            $('#passwordGroup').attr('hidden',true)
            $('#formLabel').text('Restore Employee');
            $('#addBtn').text('Restore').attr('data-id', id).removeClass('btn-primary btn-success').addClass("btn-warning");
        }
    });
</script>