<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/forgotPass.css">
</head>
<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

include '../../includes/connection.php';
include "../../includes/security.php";

$msg = "";

if (isset($_POST['mail'])) {
    $userEmail = $_POST['mail'];

    // Prepare SELECT statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id_user'];
        $username = $row['user_name'];

        $_SESSION['id_user'] = $id;
        $_SESSION["Uname"] = $username;

        $random = rand(100000, 999999);

        // Prepare UPDATE statement
        $update = $conn->prepare("UPDATE users SET reset_token = ? WHERE id_user = ?");
        $update->bind_param("ii", $random, $id);
        $update->execute();
        $update->close();

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rogerfahed9@gmail.com';
            $mail->Password = 'ndce nmau gfhv wiok'; // Consider moving this to an .env file or config outside of public code
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('rogerfahed9@gmail.com', "medCare");
            $mail->addAddress($userEmail, $username);

            $mail->isHTML(true);
            $mail->Subject = "Forgot password";
            $mail->Body = "This is your code: <strong>{$random}</strong>. Do not share it with anyone.";

            if ($mail->send()) {
                header("Location: ./checkToken.php");
                exit();
            } else {
                echo "<script>alert('Failed to send email. Please try again.'); window.history.back();</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Mailer Error: " . $mail->ErrorInfo . "'); window.history.back();</script>";
        }
    } else {
        $msg = "Invalid email address";
    }

    $stmt->close();
}
?>

<body>
<div class="background">
    <div class="glow"></div>
  </div>
  <div class="login-container">

    <div class="login-card">
        <h1>Forgot password?</h1>
      <p>Enter your email to reset your password</p>

      <form action="./forgotPass.php" method="POST">

      <p id="mail-error" style="color: red;"><?php echo "$msg"; ?></p>
        <input type="text" placeholder="Your Email" name="mail" id="mail" autocomplete="off" required>
        <button id="login" onclick="validateMail()">Forgot Password</button>

      </form>
    </div>
    
  </div>
  <script>
    let errorMail = document.getElementById("mail-error");

    function validateMail() {
    let mail = document.getElementById("mail").value.trim();
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (mail.length > 0 && !emailPattern.test(mail)) {
        errorMail.innerHTML = "Enter a valid email address.";
        event.preventDefault(); 
    } else {
        document.querySelector('form').submit();
    }
}

  </script>
</body>
</html>