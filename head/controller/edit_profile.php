<?php 
include '../../conn/conn.php';

$db = new DatabaseHandler();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
   
    $user_id = $_SESSION['id'];


    // Get profile data
    $fname = $_POST['fname'] ?? '';
    $mname = $_POST['mname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $data_details = array(
        'address' => $address,
        'birthday' => $birthday,
        'phone' => $phone,
        'gender' => $gender,
        'fname' => $fname,
        'mname' => $mname,
        'lname' => $lname,
    );
    // Handle file upload
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profilePic']['tmp_name'];
        $fileName = $_FILES['profilePic']['name'];
        $fileSize = $_FILES['profilePic']['size'];
        $fileType = $_FILES['profilePic']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validate file extension (e.g., jpg, jpeg, png)
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fileExtension, $allowedExtensions)) {
            // New file name to avoid conflicts
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../../profile/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $data_details['profile_picture'] = $newFileName;
            } else {
                echo json_encode(['error' => 'There was an error moving the file.']);
                exit;
            }
        } else {
            echo json_encode(['error' => 'Invalid file type.']);
            exit;
        }
    }

    $whereClause = array(
        'user_id' => $user_id
    );

    if(($db->updateData('user_details',$data_details,$whereClause))){
        echo json_encode(['success' => true]);
    }else{
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
