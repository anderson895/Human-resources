<?php include 'components/header.php' ?>


    <?php 
    // Whitelist of allowed pages
    $allowedPages = ['upload_documents', 'leave_request', 'attendance', 'attendance_history','profile']; // Add your allowed file names here
    
    if (isset($_GET['p'])) {
        // Get the page name from the URL
        $page = $_GET['p'];
    
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
