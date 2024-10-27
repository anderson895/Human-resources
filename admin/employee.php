<!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Manage Employee Accounts</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">Employee Accounts</h6>
        <button class="btn btn-primary my-1 addBtn" data-toggle="modal" data-target="#formModal">Add Employee</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Hired Date</th>
                        <th>Until Date</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Birthday</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php 
                    $rows = $db->getAllEmployee(0);

                    if(count($rows)>0){
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $email = $row['email'];
                            $fname = ucwords($row['fname']);
                            $mname = ucwords($row['mname']);
                            $lname = ucwords($row['lname']);
                            $address = ucwords($row['address']);
                            $gender = ucwords($row['gender']);
                            $birthday = $row['birthday'];
                            $phone = $row['phone'];
                            $position = ucwords($row['position']);
                            $role = ($row['role']);

                            $date_hired = $db->getIdByColumnValue("user_hired","user_id",$id,"date_from");
                            $date_hired = $date_hired !="" ? $date_hired : "None";
                            $date_until = $db->getIdByColumnValue("user_hired","user_id",$id,"date_to");
                            $date_until = $date_until !="" ? $date_until : "None";

                            $data='
                                data-id="'.$id.'"
                                data-email="'.$email.'"
                                data-role="'.$role.'"
                                data-fname="'.$fname.'"
                                data-mname="'.$mname.'"
                                data-lname="'.$lname.'"
                                data-gender="'.$gender.'"
                                data-address="'.$address.'"
                                data-birthday="'.$birthday.'"
                                data-phone="'.$phone.'"
                                data-position="'.$position.'"
                                data-date_hired="'.$date_hired.'"
                                data-date_until="'.$date_until.'"
                            ';
                            
                            
                            $action = '<button '.$data.' data-type="update" data-toggle="modal" data-target="#formModal" class="editBtn btn btn-success">Edit</button>
                                        <button '.$data.' data-type="delete" data-toggle="modal" data-target="#formModal" class="deleteBtn btn btn-danger">Delete</button>
                                        ';
                            echo '<tr>
                                <td>'.$fname.' '.$mname.' '.$lname.'</td>
                                <td>'.$position.'</td>
                                <td>'.$date_hired.'</td>
                                <td>'.$date_until.'</td>
                                <td>'.$email.'</td>
                                <td>'.$gender.'</td>
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
                        <label for="employeeFName">First Name</label>
                        <input type="text" class="form-control" id="employeeFName" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="employeeMName">Middle Name</label>
                        <input type="text" class="form-control" id="employeeMName" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="employeeLName">Last Name</label>
                        <input type="text" class="form-control" id="employeeLName" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="employeeEmail">Email </label>
                        <input type="email" class="form-control" id="employeeEmail" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="employeeGender">Gender</label>
                        <select name="employeeGender" class="form-control mb-3" id="employeeGender" >
                            <option value="" selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="employeeAddress">Address</label>
                        <input type="text" class="form-control" id="employeeAddress" placeholder="Enter Address">
                    </div>
                    <div class="form-group">
                        <label for="employeeBirthday">Birthday</label>
                        <input type="date" class="form-control" id="employeeBirthday" placeholder="Enter Birthday">
                    </div>
                    <div class="form-group">
                        <label for="employeePhone">Phone</label>
                        <input type="number" class="form-control" id="employeePhone" placeholder="Enter Phone">
                    </div>
                    <div class="form-group">
                        <label for="employeeDate_hired">Date Hired</label>
                        <input type="date" class="form-control" id="employeeDate_hired" placeholder="Enter Date Hired">
                    </div>
                    <div class="form-group">
                        <label for="employeeDate_until">Date Until</label>
                        <input type="date" class="form-control" id="employeeDate_until" placeholder="Enter Date Until">
                    </div>
                    <div class="form-group">
                        <label for="employeePosition">Position</label>
                        <input type="text" class="form-control" id="employeePosition" placeholder="Enter Position">
                    </div>
                    <div class="form-group">
                        <label for="employeeRole">Role</label>
                        <select name="employeeRole" id="employeeRole" class="form-control">
                            <option value="">Select Role</option>
                            <option value="employee">Employee</option>
                            <option value="head">Head Department</option>
                        </select>
                    </div>
                    <div class="form-group" id="passwordGroup" hidden>
                        <label for="employeePassword">Note : For changing password only</label>
                        <input type="password" class="form-control" id="employeePassword" placeholder="Enter Password to change">
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

$('#dataTable').on('click', '.editBtn, .deleteBtn', function() {
        // Retrieve data attributes from clicked button
        var id = $(this).data('id');
        var fname = $(this).data('fname');
        var mname = $(this).data('mname');
        var lname = $(this).data('lname');
        var email = $(this).data('email');
        var gender = $(this).data('gender');
        var address = $(this).data('address');
        var birthday = $(this).data('birthday');
        var phone = $(this).data('phone');
        var position = $(this).data('position');
        var type = $(this).data('type');
        var role = $(this).data('role');
        var date_hired = $(this).data('date_hired');
        var date_until = $(this).data('date_until');

        // Populate modal fields with employee data
        $('#employeeFName').val(fname);
        $('#employeeMName').val(mname);
        $('#employeeLName').val(lname);
        $('#employeeGender').val(gender);
        
        $('#employeeEmail').val(email);
        $('#employeeAddress').val(address);
        $('#employeeBirthday').val(birthday);
        $('#employeePhone').val(phone);
        $('#employeePosition').val(position);
        $('#employeeRole').val(role);
        $('#employeeDate_hired').val(date_hired);
        $('#employeeDate_until').val(date_until);
        
        // Change modal title and button

        if(type==="update")
        {
            $('#passwordGroup').attr('hidden',false)
            $('#formLabel').text('Edit Employee');
            $('#addBtn').text('Update').attr('data-id', id).removeClass('btn-primary btn-danger').addClass("btn-success");
        }
        if(type==="delete")
        {
            $('#passwordGroup').attr('hidden',true)
            $('#formLabel').text('Delete Employee');
            $('#addBtn').text('Delete').attr('data-id', id).removeClass('btn-primary btn-success').addClass("btn-danger");
        }
        
    });

    $('.addBtn').click(function(){
        $('#passwordGroup').attr('hidden',true)
        $('#formLabel').text('Add Employee');
        $('#addBtn').text('Add').attr('data-id', '').removeClass('btn-danger btn-success').addClass("btn-primary");
        $('#formModal').find('input, textarea, select').val('');
    })
   


</script>