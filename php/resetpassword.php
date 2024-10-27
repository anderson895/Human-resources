<?php
require '../conn/conn.php';
require '../mailer/mail_function.php';

$db = new DatabaseHandler();

if (isset($_POST['email'], $_POST['verification_code'], $_POST['new_password'])) {
    $email = trim($_POST['email']);
    $verificationCode = trim($_POST['verification_code']);
    $newPassword = trim($_POST['new_password']);

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }

    // Check if the email exists and fetch user details
    $userId = $db->getIdByColumnValue("users", "email", $email, "id");
    $storedVerificationCode = $db->getIdByColumnValue("users", "email", $email, "verification_code");

    if ($userId && $storedVerificationCode && $verificationCode!="" && $storedVerificationCode === $verificationCode) {
        // Prepare data for update
        $data = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'verification_code' => null, // Clear the verification code after successful use
        ];

        // Update the user's password and clear the verification code
        $whereClause = ['id' => $userId];

        if ($db->updateData('users', $data, $whereClause)) {
            echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update the password.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or verification code.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters.']);
}
?>
