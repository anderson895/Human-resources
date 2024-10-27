<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

// Check if the form is submitted and required fields are present
if(isset($_POST['action'],$_POST['head_Department']) && isset($_SESSION['id'])) {
    // Retrieve POST data
    $employee_id = $_SESSION["id"];
    $action = $_POST["action"];
    $head_Department = $_POST["head_Department"];
    
    if($action == 'signIn') {
        // Get the current date and time
        $curr_dateTime = date('Y-m-d H:i:s'); 

        $data = array(
            'user_id' => $employee_id,
            'sign_in' => $curr_dateTime,            
            'head_id' => $head_Department,            
        );
         
        // Insert data into the database
        if ($db->insertData('attendance', $data)) {
            echo '200'; // Success response
        } else {
            echo '403'; // Error response if insertion fails
        }
    }else if($action == 'signOut') {
        $where = 
        [
            'user_id='.$employee_id,
            'sign_out= "0000-00-00 00:00:00"',

        ];

        $row = ($db->getAllRowsFromTableWhere("attendance",$where));

        if($row[0]['id']!="")
        {
            $attendance_id = $row[0]['id'];
            $sign_in_date_time = $row[0]['sign_in'];
            $curr_dateTime = date('Y-m-d H:i:s');
            
            $signInDateTime = new DateTime($sign_in_date_time);
            $currDateTime = new DateTime($curr_dateTime);
            
            $interval = $signInDateTime->diff($currDateTime);
            $hours = $interval->h + ($interval->days * 24);

            
            
            $data = array(
                'sign_out' => $curr_dateTime,            
                'hour_count' => $hours,            
            );
            $where = array(
                'user_id' => $employee_id,
                'id' => $attendance_id,
            );
            
            // Insert data into the database
            if ($db->updateData('attendance', $data,$where)) {
                echo '200'; // Success response
            } else {
                echo '403'; // Error response if insertion fails
            }
        }
        
        
    }
}
