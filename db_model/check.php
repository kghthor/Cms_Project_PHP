<?php
// Start the session
 session_start();

// Check if the user session is set
if (isset($_SESSION['username']) && isset($_SESSION['type']) && isset($_SESSION['user_id'])) {
    // Retrieve user data from session
 $username = $_SESSION['username'];
    $userType = $_SESSION['type'];
    $userId = $_SESSION['user_id']; // Retrieve the user ID from session
    
     // Print user information
   echo "Username: " . htmlspecialchars($username) . "<br>";
     echo "User ID: " . htmlspecialchars($userId) . "<br>";
    
    // Check user type and print corresponding message
         if ($userType === 1) {
                    echo "User Type: Admin";
    } elseif ($userType === 0) {
        echo "User Type: User";
         } else {
        echo "User Type: Unknown";
     }
 } else {
     echo "No user session found.";
}
//Configure appache
?>