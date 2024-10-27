<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

// Check if the form is submitted and required fields are present
if (isset($_POST['mode']) && isset($_SESSION['id'])) {

    $employee_id = $_SESSION['id'];

    // Check if the employee has any accepted leave requests
    $where = [
        "user_id = '".$employee_id."'",
        "leave_request_status = 'accepted'"
    ];
    $rows = $db->getAllRowsFromTableWhere("leave_request", $where);
    $leave_credit_remaining = $leave_credits ;
    if(count($rows) > 0){
        $leave_credit_used = $db->getTotalLeaveCurrentYear($employee_id);

        // Calculate remaining leave credits
        $leave_credit_remaining = $leave_credits - $leave_credit_used;
        if($leave_credit_remaining <= 0) {
            echo 'You have used all leave credits';
            exit();
        }
    }

    // Check if all required fields are present for adding a new leave request
    if ($_POST['mode'] == "Add" && isset($_POST["date_from"], $_POST["date_until"], $_POST["reason"])) {

        // Retrieve POST data
        $date_from = $_POST["date_from"];
        $date_until = $_POST["date_until"];
        $reason = $_POST["reason"];
        $type = $_POST["type"];
        $head_id = $_POST["head_id"];
        
        // Calculate the number of days between date_from and date_until
        $date1 = new DateTime($date_from);
        $date2 = new DateTime($date_until);
        $interval = $date1->diff($date2);
        $leave_day_count = $interval->days + 1; // Add 1 to include the first day

        // Check if the requested leave days exceed the remaining leave credits
        if($leave_day_count <= $leave_credit_remaining) {

            // Prepare data for insertion
            $data = array(
                'head_id' => $head_id,
                'type' => $type,
                'date_from' => $date_from,
                'date_until' => $date_until,
                'reason' => $reason,
                'leave_day_count' => $leave_day_count,
                'user_id' => $employee_id,
            );

            // Insert data into the database
            if ($db->insertData('leave_request', $data)) {
                echo '300'; // Success response
            } else {
                echo '403'; // Error response if insertion fails
            }
        } else {
            echo 'You only have '.$leave_credit_remaining.' days. Please adjust your date range.';
        }
    }else // Check if all required fields are present for adding a new leave request
    if ($_POST['mode'] == "Edit" && isset($_POST["date_from"], $_POST["date_until"], $_POST["reason"])) {

        // Retrieve POST data
        $date_from = $_POST["date_from"];
        $date_until = $_POST["date_until"];
        $reason = $_POST["reason"];
        $type = $_POST["type"];
        $edit_id = $_POST["edit_id"];
        $head_id = $_POST["head_id"];

        // Calculate the number of days between date_from and date_until
        $date1 = new DateTime($date_from);
        $date2 = new DateTime($date_until);
        $interval = $date1->diff($date2);
        $leave_day_count = $interval->days + 1; // Add 1 to include the first day

        // Check if the requested leave days exceed the remaining leave credits
        if($leave_day_count <= $leave_credit_remaining) {

            // Prepare data for insertion
            $data = array(
                'head_id' => $head_id,
                'type' => $type,
                'date_from' => $date_from,
                'date_until' => $date_until,
                'reason' => $reason,
                'leave_day_count' => $leave_day_count,
            );

            $where = array(
                'id' => $edit_id,
                'user_id' => $employee_id,
            );

            // Insert data into the database
            if ($db->updateData('leave_request', $data,$where)) {
                echo '301'; // Success response
            } else {
                echo '403'; // Error response if insertion fails
            }
        } else {
            echo 'You only have '.$leave_credit_remaining.' days. Please adjust your date range.';
        }
    }else if($_POST['mode'] == "Delete")
    {
        $edit_id = $_POST["edit_id"];
        // Prepare data for insertion
        $data = array(
            'status' => 1,
        );

        $where = array(
            'id' => $_POST['edit_id'],
            'user_id' => $employee_id,
        );

        // Insert data into the database
        if ($db->updateData('leave_request', $data,$where)) {
            echo '302'; // Success response
        } else {
            echo '403'; // Error response if insertion fails
        }
    }
}
