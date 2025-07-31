<?php
include('includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust path if necessary

error_reporting(0);

if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $contactno = $_POST['contactno'];
    $status = 0; // Unverified by default
    $token = bin2hex(random_bytes(50)); // Generate a verification token

    // Check if the email already exists
    $check_query = mysqli_query($bd, "SELECT * FROM users WHERE userEmail='$email'");
    if (mysqli_num_rows($check_query) > 0) {
        $msg = "Email already exists. Please use a different email.";
    } else {
        // Insert user data into the database
        $query = mysqli_query($bd, "INSERT INTO users (fullName, userEmail, password, contactNo, status, token) VALUES ('$fullname', '$email', '$password', '$contactno', '$status', '$token')");

        if ($query) {
            // Send verification email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                             // Enable SMTP authentication
                $mail->Username = 'eiarseedeth@gmail.com';         // SMTP username
                $mail->Password = 'gpgv bypb lcux gdjq';            // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                   // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                  // TCP port to connect to

                //Recipients
                $mail->setFrom('eiarseedeth@gmail.com', 'EGS Seed');
                $mail->addAddress($email, $fullname);               // Add a recipient

                // Content
                $mail->isHTML(true);                                 // Set email format to HTML
                $mail->Subject = 'Email Verification';
                $mail->Body    = "Hi $fullname,<br><br>Please click the link below to verify your email:<br>
                                  <a href='http://knowledgebank.eiar.gov.et/sds/users/verify_email.php?token=$token'>Verify Email</a><br><br>Thank you!";
                $mail->AltBody = "Hi $fullname,\n\nPlease click the link below to verify your email:\n
                                  http://knowledgebank.eiar.gov.et/sds/users/verify_email.php?token=$token\n\nThank you!";

                $mail->send();
                header("location:verification.php?fullname=".$fullname."&email=".$email."");
                //$msg = "Registration successful. Please check your email to verify your account.";
            } catch (Exception $e) {
                $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $msg = "Error during registration. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDS | User Registration</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <script>
        function userAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: { "email": $("#email").val() },
                type: "POST",
                success: function(data) {
                    $("#user-availability-status1").html(data);
                    $("#loaderIcon").hide();
                },
                error: function () {}
            });
        }

        function userphone() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability2.php",
                data: { "contactno": $("#contactno").val() },
                type: "POST",
                success: function(data) {
                    $("#user-availability1-status1").html(data);
                    $("#loaderIcon").hide();
                },
                error: function () {}
            });
        }
    </script>
</head>
<body>
    <div id="login-page">
        <div class="container">
            <form class="form-login" method="post">
                <h2 class="form-login-heading">User Registration</h2>
                <p style="padding-left: 1%; color: green">
                    <?php if($msg) { echo htmlentities($msg); } ?>
                </p>
                <div class="login-wrap">
                    <input type="text" class="form-control" placeholder="Full Name" name="fullname" required="required" autofocus>
                    <br>
                    <input type="email" class="form-control" placeholder="Email" id="email" onBlur="userAvailability()" name="email" required="required">
                    <span id="user-availability-status1" style="font-size:12px;"></span>
                    <br>
                    <input type="password" class="form-control" placeholder="Password" required="required" name="password">
                    <br>
                    <input type="text" class="form-control" placeholder="Contact no" onBlur="userphone()"  id="contactno" name="contactno" required="required">
                    <span id="user-availability1-status1" style="font-size:12px;"></span>
                    <br>
                    <button class="btn btn-theme btn-block" type="submit" name="submit" id="submit"><i class="fa fa-user"></i> Register</button>
                    <hr>
                    <div class="registration">
                        Already Registered<br/>
                        <a class="" href="index.php">Sign in</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>
</body>
</html>
