<?php 
session_start();
if (isset($_SESSION)) {
    
    // Check if 'role' is set and not null
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        // Redirect to admin page or perform admin-related logic
        header("Location: admin");
        exit(); // Ensure no further code is executed
    } elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'employee') {
        // Redirect to employee page or perform employee-related logic
        header("Location: employee");
        exit(); // Ensure no further code is executed
    } elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'head') {
        // Redirect to employee page or perform employee-related logic
        header("Location: head");
        exit(); // Ensure no further code is executed
    }else {
        // Handle cases where the role is not set or is neither 'admin' nor 'employee'
        header("Location: index.php");
        exit(); // Ensure no further code is executed
    }
} else {
    header("Location: index.php");
}
?>
