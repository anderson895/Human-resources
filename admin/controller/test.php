<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
var_dump($_POST);
if(isset($_POST['mode']));
{
    $mode = $_POST['mode'];

    if($mode =="Add")
    {
        //Adding
        if (isset($_POST["name"])){

            $name = preg_replace('/[^a-zA-Z\s]/', '', $_POST['name']);
            $student_number = $_POST['student_number'];
            $institute = $_POST['institute'];
            $section = $_POST['section'];

            $data = array(
                'name' =>$name,
                'student_number' =>$student_number,            
                'institute' => $institute,       
                'section' => $section,       
            );
        
                if($db->insertData('student_details',$data)){
                        echo '200';
                }else{
                        // echo '403';
                    }
            }
    }
    else if($mode=="Edit")
    {
        //Editing 
        $edit_id = $_POST["edit_user_id"];
        
        if ($edit_id !=0){

            $name = preg_replace('/[^a-zA-Z\s]/', '', $_POST['name']);
            $student_number = $_POST['student_number'];
            $institute = $_POST['institute'];
            $section = $_POST['section'];

            $data = array(
                'name' => $name,
                'student_number' => $student_number,            
                'institute' => $institute,       
                'section' => $section,       
            );
            $whereClause = array(
                    'id' => $_POST['edit_user_id']
                );
        
            
                    if(($db->updateData('student_details',$data,$whereClause))){
                        echo '200';
                    }else{
                        echo '500';
                    }
                  
            }
    }

    else if($mode=="Delete")
    {
        //Soft Delete 
        $edit_id = $_POST["edit_user_id"];
        
        if ($edit_id !=0){

            $data = array(
                'status' =>1,
            );
            $whereClause = array(
                    'id' => $_POST['edit_user_id']
                );
        
    
            if(($db->updateData('student_details',$data,$whereClause))){
                echo '200';
            }else{
                echo '500';
            }
                  
            }
    }
}
