<?php 
include '../../conn/conn.php';
include '../../mailer/mail_function.php';
$db = new DatabaseHandler();

// var_dump($_POST);

if (isset($_POST['status'])) {
    // Define the valid status values
    $validStatuses = ['for review', 'for interview', 'for requirements', 'for processing', 'hired','declined'];
    
    // Check if the status is in the valid statuses array
    if (in_array($_POST['status'], $validStatuses)) {
        $status = $_POST['status'];
        $applicant_id = $_POST['applicant_id'];
        $user_id = $_POST['user_id'];
        $message = $_POST['message'];
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        
        // Prepare data for update
        $data_details = array(
            'application_status' => $status,
        );
        
        // Prepare where clause
        $whereClause = array(
            'user_id' => $user_id
        );

        $email = $db->getIdByColumnValue("users","id",$user_id,"email");
        
        // Perform the update operation
        if($email!=""){
            if ($db->updateData('job_applications', $data_details, $whereClause)) {
                // Update successful
                $password = generateRandomPassword();
                $emailResponse = SendEmailApplicantStatus($email, $status,$password,$message);

                if ($emailResponse == "send") {
                    if($status=="hired")
                    {
                        $data = array(
                            'password' => password_hash($password, PASSWORD_DEFAULT),
                            'role' => 'employee'
                        );

                        $data_hired = array(
                            'user_id' => $user_id,
                            'date_from' => $date_from,
                            'date_to' => $date_to
                        );

                        $whereClause = array(
                            'id' => $user_id
                        );
        
                        if(($db->updateData('users',$data,$whereClause)) && $db->insertData('user_hired',$data_hired) ){
                            echo "Update successful";
                        }else{
                            echo "Update failed";
                        }
        
                    }else{
                        echo "Update successful";
                    }
                }
                
            } else {
                // Update failed
                echo "Update failed";
            }
        }else{
                echo "Update failed";
        }
    } else {
        // Invalid status
        echo "Invalid status";
    }
}

function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+';
    $charactersLength = strlen($characters);
    $randomPassword = '';

    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomPassword;
}
?>
