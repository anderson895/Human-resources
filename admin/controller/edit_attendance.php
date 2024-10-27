<?php 
include '../../conn/conn.php';
$db = new DatabaseHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required POST variables are set
    if (isset($_POST['attendance_id'], $_POST['sign_in'], $_POST['sign_out'], $_POST['hour_count'], $_POST['verify_status'])) {
        $attendance_id = $_POST['attendance_id'];
        $sign_in = $_POST['sign_in'];
        $sign_out = $_POST['sign_out'];
        $hour_count = $_POST['hour_count'];
        $verify_status = strtolower($_POST['verify_status']);

        // Convert datetime-local format (YYYY-MM-DDTHH:MM) to the format your database uses (e.g., Y-m-d H:i:s)
        $sign_in = DateTime::createFromFormat('Y-m-d\TH:i', $sign_in)->format('Y-m-d H:i:s');
        $sign_out = $sign_out ? DateTime::createFromFormat('Y-m-d\TH:i', $sign_out)->format('Y-m-d H:i:s') : null;

        // Prepare the data array
        $data_details = array(
            'sign_in' => $sign_in,
            'sign_out' => $sign_out,
            'hour_count' => $hour_count,
            'verify_status' => $verify_status,
        );

        // Prepare the where clause
        $whereClause = array(
            'id' => $attendance_id
        );

        // Attempt to update the record in the database
        if ($db->updateData('attendance', $data_details, $whereClause)) {
            echo "301";
        } else {
            echo "Error updating details.";
        }
    } else {
        echo "Required fields are missing.";
    }
} else {
    echo "Invalid request method.";
}
?>
