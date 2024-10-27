<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Attendance History</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-lg-flex text-center justify-content-lg-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary my-1">History</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sign in</th>
                        <th>Sign out</th>
                        <th>Hour Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php 

                    $where = [
                        'user_id="'.$_SESSION['id'].'"'
                    ];
                    $rows = $db->getAllRowsFromTableWhere('attendance',$where);

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
                                <td>'.$id.'</td>
                                <td>'.$formatted_sign_in.'</td>
                                <td>'.$formatted_sign_out.'</td>
                                <td>'.$hour_count.'</td>
                                <td>'.$verify_status.'</td>
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
<link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.4/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/r-3.0.2/datatables.min.css" rel="stylesheet">
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.4/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/r-3.0.2/datatables.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    new DataTable('#dataTable', {
        responsive: true,
        columnDefs: [
            {
                targets: 0, // Target the first column
                visible: false // Hide the column
            }
        ],
        order: [[0, 'desc']] // Sort by the first column in ascending order
    });
});
</script>

