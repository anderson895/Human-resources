<?php 
include '../../conn/conn.php';
$db = new DatabaseHandler();

include '../../mailer/mail_function.php';

if (isset($_POST['Type'])) {
    $type = $_POST['Type'];

    if ($type == "Add") {
        $FName = $_POST['FName'];
        $MName = $_POST['MName'];
        $LName = $_POST['LName'];
        $Email = $_POST['Email'];
        $Gender = $_POST['Gender'];

        $Address = $_POST['Address'];
        $Birthday = $_POST['Birthday'];
        $Phone = $_POST['Phone'];
        $Position = $_POST['Position'];
        $employeeRole = $_POST['employeeRole'];
        $employeeDate_hired = $_POST['employeeDate_hired'];
        $employeeDate_until = $_POST['employeeDate_until'];
        
        $password = generateRandomPassword();

        $data = array(
            'email' => $Email,            
            'password' => password_hash($password, PASSWORD_DEFAULT),            
            'role' => $employeeRole,            
        );

        // Attempt to insert user data
        if ($db->insertData("users", $data)) {
            // Try sending the email and store the result
            $emailResponse = SendEmail($Email, $password);

            // Check if the email was sent successfully
            if ($emailResponse == "send") {
                // Get the last inserted ID for users table
                $last_id = $db->getLastInsertId();

                // Prepare data for user_details table
                $data = array(
                    'user_id' => $last_id,
                    'address' => $Address,
                    'birthday' => $Birthday,
                    'phone' => $Phone,
                    'position' => $Position,
                    'gender' => $Gender,
                    'fname' => $FName,
                    'mname' => $MName,
                    'lname' => $LName,
                );

                // Attempt to insert user details data
                if ($db->insertData("user_details", $data)) {
                  // Prepare data for user_hired table
                    $data_hired = array(
                        'user_id' => $last_id,
                        'date_from' => $employeeDate_hired,
                        'date_to' => $employeeDate_until,
                    );
                    if ($db->insertData("user_hired", $data_hired)) {
                          echo "User added successfully!";
                    } else {
                        echo "Error adding user details.";
                    }
                } else {
                    echo "Error adding user details.";
                }
            } else {
                echo "Error sending email: " . $emailResponse;
            }
        } else {
            echo "Error adding user.";
        }
    }
    else if($type =="Update")
    {
        $FName = $_POST['FName'];
        $MName = $_POST['MName'];
        $LName = $_POST['LName'];
        $Email = $_POST['Email'];
        $Gender = $_POST['Gender'];


        $Email = $_POST['Email'];
        $Address = $_POST['Address'];
        $Birthday = $_POST['Birthday'];
        $Phone = $_POST['Phone'];
        $Position = $_POST['Position'];
        $employeeDate_hired = $_POST['employeeDate_hired'];
        $employeeDate_until = $_POST['employeeDate_until'];

         //Edit 
         $id = $_POST["id"];

            $data = array(
                'email' => $Email,
            );
            $password = trim($_POST['changepassword']);
                
            if ($password != "") {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT); 
            }

             $whereClause = array(
                     'id' => $id
                 );
         
     
             if(($db->updateData('users',$data,$whereClause))){
                

                $data_details = array(
                    'address' => $Address,
                    'birthday' => $Birthday,
                    'phone' => $Phone,
                    'position' => $Position,
                    'gender' => $Gender,
                    'fname' => $FName,
                    'mname' => $MName,
                    'lname' => $LName,
                );

                $whereClause = array(
                    'user_id' => $id
                );

                if(($db->updateData('user_details',$data_details,$whereClause))){

                    $checker = $db->getIdByColumnValue("user_hired","user_id",$id,"user_id");

                    if($checker!="")
                    {
                        $data_hired = array(
                            'date_from' => $employeeDate_hired,
                            'date_to' => $employeeDate_until,
                        );
                        if(($db->updateData('user_hired',$data_hired,$whereClause))){
                            echo "User Edited successfully!";
                        }else{
                            echo "Error Updating details";
                        }
                    }else 
                    {
                        $data_hired = array(
                            'date_from' => $employeeDate_hired,
                            'date_to' => $employeeDate_until,
                            'user_id' => $id,
                        );
                        if(($db->insertData('user_hired',$data_hired))){
                            echo "User Edited successfully!";
                        }else{
                            echo "Error Updating details";
                        }
                    }

                    


                }else{
                    echo "Error Updating details";
                }

             }else{
                echo "User Duplicated Email!";
             }
                   
    }
    else if($type =="Delete")
    {

         //Soft Delete 
         $id = $_POST["id"];

             $data = array(
                 'status' =>1,
             );
             $whereClause = array(
                     'id' => $id
                 );
         
     
             if(($db->updateData('users',$data,$whereClause))){
                echo "User Deleted successfully!";
             }else{
                echo "User Not Deleted!";
             }
    }else if($type =="Restore")
    {

         //Soft Delete 
         $id = $_POST["id"];

             $data = array(
                 'status' =>0,
             );
             $whereClause = array(
                     'id' => $id
                 );
         
     
             if(($db->updateData('users',$data,$whereClause))){
                echo "User Restored successfully!";
             }else{
                echo "User Not Restored!";
             }
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
