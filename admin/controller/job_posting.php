<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
// var_dump($_POST);
// var_dump($_FILES);
// Check if the form is submitted and required fields are present
if(isset($_POST['mode']))
{
    $mode = $_POST['mode'];

    if($mode=="Add")
    {
        if (isset($_POST["title"], $_POST["description"]) && isset($_FILES["image"])) {

            // Retrieve POST data
            $title = $_POST["title"];
            $description = $_POST["description"];
            $location = $_POST["location"];
            $position = $_POST["position"];
            
            // Handle file upload
            $file = $_FILES["image"];
            $uploadDir = '../uploads/job_posting/'; // Directory to save the uploaded files
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
                    'title' => $title,
                    'description' => $description,            
                    'location' => $location,            
                    'position' => $position,            
                    'image' => $fileName,  // Save the file path to the database     
                );
                
                // Insert data into the database
                if ($db->insertData('job_posting', $data)) {
                    echo '200'; // Success response
                } else {
                    echo '403'; // Error response if insertion fails
                }
            } else {
                echo 'Error uploading file.';
            }
        }else{
            echo '403'; // Error response if insertion fails
        }
    }else if($mode =="Update")
    {
        if (isset($_POST["title"], $_POST["description"]) && isset($_FILES["image"])) {

            // Retrieve POST data
            $title = $_POST["title"];
            $description = $_POST["description"];
            $location = $_POST["location"];
            $position = $_POST["position"];
            

            $data = array(
                'title' => $title,
                'description' => $description,            
                'location' => $location,            
                'position' => $position,            
            );


           if(isset($_FILES['image']['name']) && $_FILES['image']['name']!="")
           {
             // Handle file upload
             $file = $_FILES["image"];
             $uploadDir = '../uploads/job_posting/'; // Directory to save the uploaded files
             $fileName = basename($file["name"]);
             
             // Remove spaces and unwanted characters from the filename
             $randomNumber = mt_rand(100000, 999999);
    // Remove spaces and unwanted characters from the filename
    $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $randomNumber.$fileName);
             
             $targetFilePath = $uploadDir . $fileName;
             
             // Move uploaded file to the target directory
             if (move_uploaded_file($file["tmp_name"], $targetFilePath))
             {
                $data['image']=$fileName;
             }
           }

           //Edit 
         $id = $_POST["edit_id"];

         $whereClause = array(
                 'id' => $id
             );
     
 
         if(($db->updateData('job_posting',$data,$whereClause))){
            echo "200";
         }else{
            echo "403";
         }


        }else{
            echo '403'; // Error response if insertion fails
        }
    }else if($mode=="Delete")
    {
        $id = $_POST["edit_id"];
        $data = array(
            'status' => 1,
        );
         $whereClause = array(
                 'id' => $id
             );
     
 
         if(($db->updateData('job_posting',$data,$whereClause))){
            echo "200";
         }else{
            echo "403";
         }


        }else{
            echo '403'; // Error response if insertion fails
        }
    }
