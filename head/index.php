<?php include 'components/header.php' ?>


    <?php 
    // Whitelist of allowed pages
    $allowedPages = ['attendance_history','employee_leave_request','employee_leave_request_history','attendance','profile']; // Add your allowed file names here
    
    if (isset($_GET['i'])) {
        // Get the page name from the URL
        $page = $_GET['i'];
    
        // Sanitize the input by removing any non-alphanumeric characters
        $page = preg_replace('/[^a-zA-Z0-9_]/', '', $page);
    
        // Use basename() to prevent directory traversal
        $page = basename($page);
    
        // Check if the requested page is in the allowed list
        if (in_array($page, $allowedPages)) {
            // Construct the file path
            $filePath = $page . '.php';
    
            // Check if the file exists
            if (file_exists($filePath)) {
                // Include the file
                include $filePath;
            } else {
                // File does not exist, handle the error
                echo "Error: The requested page does not exist.";
            }
        } else {
                 include '404.php';
            }
        }else{
            include 'attendance.php';
        }

    
    ?>

<!-- /.container-fluid -->
<?php include 'components/footer.php' ?>
