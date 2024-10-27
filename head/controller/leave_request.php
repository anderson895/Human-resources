<?php 
require '../../conn/conn.php';
include '../../mailer/mail_function.php';

$db = new DatabaseHandler();
// $emailResponse = SendEmailApplicantStatus($email, $status,$password);

// Check if the form is submitted and required fields are present
if (isset($_POST['mode']) && isset($_SESSION['id'])) {
    if($_POST['mode'] == "Confirm" )
    {
        $status_request = $_POST["status_request"];
        $edit_id = $_POST["edit_id"];
        // Prepare data for insertion
        $data = array(
            'leave_request_status' => $status_request,
        );

        $where = array(
            'id' => $edit_id,
        );

        $user_id = $db->getIdByColumnValue("leave_request","id",$edit_id,"user_id");
        $email = $db->getIdByColumnValue("users","id",$user_id,"email");
        
        
        // Insert data into the database
        if ($db->updateData('leave_request', $data,$where)) {
            if(SendEmailLeaveRequestStatus($email,$status_request,$status_request)){
                echo '301'; // Success response
            }else {
                echo '403'; // Error response if insertion fails
            }
        } else {
            echo '403'; // Error response if insertion fails
        }
    }
}
