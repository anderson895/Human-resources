<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

// Check if the form is submitted and required fields are present
if(isset($_POST['action']) && isset($_SESSION['id'])) {

    $action = $_POST['action'];

    if($action=="verify")
    {
        $id = $_POST["id"];

        $data = array(
            'verify_status' => 'verified',            
        );
        $where = array(
            'id' => $id,
        );
        
        // Insert data into the database
        if ($db->updateData('attendance', $data,$where)) {
            echo '301'; // Success response
        } else {
            echo '403'; // Error response if insertion fails
        }
    }else if($action=="reject")
    {
        $id = $_POST["id"];

        $data = array(
            'verify_status' => $action,            
        );
        $where = array(
            'id' => $id,
        );
        
        // Insert data into the database
        if ($db->updateData('attendance', $data,$where)) {
            echo '301'; // Success response
        } else {
            echo '403'; // Error response if insertion fails
        }
    }
    

        
}
