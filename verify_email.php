<?php
include('includes/config.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid
    $query = mysqli_query($bd, "SELECT * FROM users WHERE token='$token'");
    if (mysqli_num_rows($query) > 0) {
        // Update user status to verified
        mysqli_query($bd, "UPDATE users SET status=2, token='' WHERE token='$token'");
        echo "Your email has been verified. You can now log in.";
		
				header('location:index.php');
				
				
    } else {
        echo "Invalid token. Please check your email for the verification link.";
    }
} else {
    echo "No token provided.";
}
?>