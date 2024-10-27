<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

// Check if the form is submitted and required fields are present
if(isset($_POST['mode']) && isset($_SESSION['id']))
{
    if (isset($_SESSION["id"], $_POST["description"]) && isset($_FILES["file"]) && $_POST['mode'] == "Add") {

        // Retrieve POST data
        $employee_id = $_SESSION["id"];
        $description = $_POST["description"];
        $file_type = $_POST["file_type"];
        
        // Handle file upload
        $file = $_FILES["file"];
        $uploadDir = '../../admin/uploads/'; // Directory to save the uploaded files
        $fileName = basename($file["name"]);
        
        // Remove spaces and unwanted characters from the filename
        $randomNumber = mt_rand(100000, 999999);
    // Remove spaces and unwanted characters from the filename
    $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $randomNumber.$fileName);
        
        $targetFilePath = $uploadDir . $fileName;
        
        // Move uploaded file to the target directory
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            // Prepare data for insertion
            $data = array(
                'employee_id' => $employee_id,
                'description' => $description,            
                'file_type' => $file_type,            
                'added_by' => 'employee',            
                'file' => $fileName,  // Save the file path to the database     
            );
            
            // Insert data into the database
            if ($db->insertData('employee_files', $data)) {
                echo '200'; // Success response
            } else {
                echo '403'; // Error response if insertion fails
            }
        } else {
            echo 'Error uploading file.';
        }
    }else if(isset($_POST["fileId"]) && $_POST['mode'] == "Update")
    {
         //Soft Delete 
         $edit_id = $_POST["fileId"];
         $description = $_POST["description"];
         $file_type = $_POST["file_type"];

         if ($edit_id !=0){
    
             $data = array(
                 'description' =>$description,
                 'file_type' =>$file_type,
             );

             $file = $_FILES["file"];

             if($file['name']!="")
             {
                $uploadDir = '../../admin/uploads/'; // Directory to save the uploaded files
                $fileName = basename($file["name"]);
                
                // Remove spaces and unwanted characters from the filename
                $randomNumber = mt_rand(100000, 999999);
    // Remove spaces and unwanted characters from the filename
    $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $randomNumber.$fileName);
                
                $targetFilePath = $uploadDir . $fileName;
                
                // Move uploaded file to the target directory
                if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                    $data['file']=$fileName;
                }
             }
             $whereClause = array(
                     'id' => $edit_id,
                     'employee_id' => $_SESSION['id']
                 );
         
             if(($db->updateData('employee_files',$data,$whereClause))){
                 echo '202';
             }else{
                 echo '500';
             }
                   
            }
    } else if(isset($_POST["fileId"]) && $_POST['mode'] == "Delete")
    {
         //Soft Delete 
         $edit_id = $_POST["fileId"];
            
         if ($edit_id !=0){
    
             $data = array(
                 'status' =>1,
             );
             $whereClause = array(
                     'id' => $_POST['fileId']
                 );
         
             if(($db->updateData('employee_files',$data,$whereClause))){
                 echo '203';
             }else{
                 echo '500';
             }
                   
            }
    } 
}


else {
    echo 'Required fields are missing.';
}
?>
