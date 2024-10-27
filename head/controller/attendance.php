<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

// Check if the form is submitted and required fields are present
if(isset($_POST['action']) && isset($_SESSION['id'])) {

    $action = $_POST['action'];

    if ($action == "verify") {
        $id = $_POST["id"];

        $data = array(
            'verify_status' => 'verified',
        );
        $where = array(
            'id' => $id,
        );

        // Update data in the database
        if ($db->updateData('attendance', $data, $where)) {
            echo '301'; // Success response
        } else {
            echo '403'; // Error response if update fails
        }
    } else if ($action == "reject") {
        $id = $_POST["id"];

        $data = array(
            'verify_status' => 'rejected',
        );
        $where = array(
            'id' => $id,
        );

        // Update data in the database
        if ($db->updateData('attendance', $data, $where)) {
            echo '301'; // Success response
        } else {
            echo '403'; // Error response if update fails
        }
    } else if ($action == "reject") {
        $id = $_POST["id"];

        $data = array(
            'verify_status' => 'rejected',
        );
        $where = array(
            'id' => $id,
        );

        // Update data in the database
        if ($db->updateData('attendance', $data, $where)) {
            echo '301'; // Success response
        } else {
            echo '403'; // Error response if update fails
        }
    } else if ($action == "verifyAll") {
        $ids = $_POST["ids"]; // Expecting an array of IDs
        $success = true;

        foreach ($ids as $id) {
            $data = array(
                'verify_status' => 'verified',
            );
            $where = array(
                'id' => $id,
            );

            // Update data in the database
            if (!$db->updateData('attendance', $data, $where)) {
                $success = false;
                break; // Exit loop on first failure
            }
        }

        if ($success) {
            echo '301'; // Success response
        } else {
            echo '403'; // Error response if any update fails
        }
    }
}
?>
