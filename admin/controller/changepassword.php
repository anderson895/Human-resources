<?php 
include '../../conn/conn.php';

$db = new DatabaseHandler();

$response = array('success' => false, 'message' => 'Update failed');

if (isset($_SESSION['id'])) {
    if (isset($_POST['oldPassword'], $_POST['newPassword'])) {

        $user_id = $_SESSION['id'];

        // Fetch the hashed password from the database
        $old_password_hash = $db->getIdByColumnValue("users", "id", $user_id, "password");

        if (password_verify($_POST['oldPassword'], $old_password_hash)) {
            $new_password = $_POST['newPassword'];

            // Prepare data for update
            $data = array(
                'password' => password_hash($new_password, PASSWORD_DEFAULT),
            );
            $whereClause = array(
                'id' => $user_id
            );

            // Update the password in the database
            if ($db->updateData('users', $data, $whereClause)) {
                $response['success'] = true;
                $response['message'] = 'Password update successful';

                // Optionally, you can send a confirmation email using the mail_function.php
                // send_mail_function($user_email, "Your password has been changed", "Your password was successfully updated.");

            } else {
                $response['message'] = 'Failed to update the password. Please try again.';
            }
        } else {
            $response['message'] = 'The old password is incorrect.';
        }
    } else {
        $response['message'] = 'Incomplete request. Please provide both old and new passwords.';
    }
} else {
    $response['message'] = 'User session not found. Please log in again.';
}

// Output response as JSON for AJAX
echo json_encode($response);
?>
