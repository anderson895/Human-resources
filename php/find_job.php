<?php 
include '../conn/conn.php';
include '../mailer/mail_function.php';
$db = new DatabaseHandler();

if (isset($_POST['application_id'])) {
    $application_id = $_POST['application_id'];
    $FName = $_POST['fname'];
    $MName = $_POST['mname'];
    $LName = $_POST['lname'];
    $Email = $_POST['email'];
    $gender = $_POST['gender'];

    // Validate email
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL))  {
        echo "The email address is not valid.";
        exit;
    }
    
    // Validate the uploaded file type (only allow PDF or Word documents)
    $file = $_FILES["resume"];
    $fileType = mime_content_type($file["tmp_name"]);
    $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    if (!in_array($fileType, $allowedTypes)) {
        echo "Only PDF or Word documents are allowed.";
        exit;
    }

    // Get job title by application ID
    $title = $db->getIdByColumnValue("job_posting", "id", $application_id, "title");
    if ($title == "") {
        echo "Error adding user details.";
        exit;
    }

    $Address = $_POST['address'];
    $Birthday = $_POST['birthday'];
    $Phone = $_POST['phone'];

    // Generate a random password
    $password = generateRandomPassword();

    // Prepare data for the users table
    $userData = [
        'email' => $Email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'applicant',
    ];

    // Insert user data
    if ($db->insertData("users", $userData)) {
        $last_id = $db->getLastInsertId();

        // Prepare data for user_details table
        $userDetailsData = [
            'user_id' => $last_id,
            'fname' => $FName,
            'mname' => $MName,
            'lname' => $LName,
            'gender' => $gender,
            'address' => $Address,
            'birthday' => $Birthday,
            'phone' => $Phone,
            'position' => $title,
            
        ];

        // Insert user details data
        if ($db->insertData("user_details", $userDetailsData)) {
            $uploadDir = '../admin/uploads/'; // Directory to save the uploaded files
            $randomNumber = mt_rand(100000, 999999);

            // Sanitize file name and append random number
            $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $randomNumber . basename($file["name"]));
            $targetFilePath = $uploadDir . $fileName;

            // Move the uploaded file
            if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                // Prepare data for employee_files table
                $employeeFilesData = [
                    'employee_id' => $last_id,
                    'file_type' => 'Resume/CV',
                    'description' => 'Resume/CV',
                    'added_by' => 'employee',
                    'file' => $fileName,
                ];

                // Insert file data and job application
                if ($db->insertData('employee_files', $employeeFilesData)) {
                    $jobApplicationData = [
                        'user_id' => $last_id,
                        'job_id' => $application_id,
                    ];

                    if ($db->insertData("job_applications", $jobApplicationData)) {
                        echo "User added successfully!";
                    } else {
                        echo "Error adding job application.";
                    }
                } else {
                    echo "Error saving file data.";
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Error adding user details.";
        }

        // Send email to applicant
        $emailResponse = SendEmailApplicant($Email);
        if ($emailResponse !== "send") {
            echo "Error sending email: " . $emailResponse;
        }
    } else {
        echo "Error adding user.";
    }
}

function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+';
    $randomPassword = '';

    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $randomPassword;
}
?>
