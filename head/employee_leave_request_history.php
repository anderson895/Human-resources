<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Leave Request History</h1>

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
                    </tr>
                </thead>
                
                <tbody>
                <?php 
                    $rows = $db->getAllRowsFromTableWhere("leave_request", [
                        "head_id = ".$_SESSION['id'],
                    ]);

                    if(count($rows)>0){
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $user_id = $row['user_id'];
                            $employee_name = $db->getIdByColumnValue("user_details","user_id",$user_id,"fname").' '.$db->getIdByColumnValue("user_details","user_id",$user_id,"lname");
                            $type = ucwords($row['type']);
                            $reason = ucwords($row['reason']);
                            $date_from = ucwords($row['date_from']);
                            $date_until = $row['date_until'];
                            $leave_request_status = ucwords($row['leave_request_status']);
                            $leave_day_count = $row['leave_day_count'];

                            
                           
                            echo '<tr>
                                <td>'.ucwords($employee_name).'</td>
                                <td>'.$type.'</td>
                                <td>'.$reason.'</td>
                                <td>'.$date_from.'</td>
                                <td>'.$date_until.'</td>
                                <td>'.$leave_day_count.'</td>
                                <td>'.$leave_request_status.'</td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




<script src="js/alertmaker.js"></script>
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
                    title: 'Employee Leave Request',
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