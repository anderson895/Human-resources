<?php 
require '../conn/conn.php';
require '../mailer/mail_function.php';

$db = new DatabaseHandler();

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Validate if the input is a valid email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }

    // Fetch user ID by email
    $result = $db->getIdByColumnValue("users", "email", $email, "id");
    $role = $db->getIdByColumnValue("users", "email", $email, "role");

    if ($result != "" && $role !="" && $role !="applicant") {
        // Generate verification code
        $code = generateVerificationCode(); 

        $data = array(
            'verification_code' => $code 
        );
        $whereClause = array(
            'id' => $result
        );

        // Update the user record with the verification code
        if ($db->updateData('users', $data, $whereClause)) {
            // Send verification code via email
            if (SendEmailPasswordChangeVerification($email, $code)=="send") { 
                echo json_encode(['status' => 'success', 'message' => 'Verification code sent successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send verification code.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update verification code.']);
        }
    } else {
        // Email does not exist
        echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No email provided.']);
}

function generateVerificationCode($length = 6) {
    // Define characters to be used in the verification code
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $verificationCode = '';

    // Generate a random string of the specified length
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, $charactersLength - 1);
        $verificationCode .= $characters[$randomIndex];
    }

    return $verificationCode;
}


?>
