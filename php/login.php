<?php 
require '../conn/conn.php';
$db = new DatabaseHandler();

// Check if email and password are set
if (isset($_POST['email_Login']) && isset($_POST['password_Login'])) {

    $email = $_POST['email_Login'];
    $password = $_POST['password_Login'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email format';
        exit();
    }

    // Validate password (e.g., checking if it's not empty or meets certain criteria)
    if (empty($password)) {
        echo 'Password cannot be empty';
        exit();
    }

    // Attempt to login
    if ($db->loginUser($email, $password)) {
        echo '200';
    } else {
        echo '404';
    }

} else {
    echo 'Email and password must be provided';
}
