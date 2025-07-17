<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/checkToken.css">
</head>

<?php
<<<<<<< Updated upstream
include "../../includes/connection.php";
session_start();
=======
include "../../includes/security.php";

include "../../includes/connection.php";

>>>>>>> Stashed changes

if(isset($_POST['code'])){
    $code = $_POST['code'];
    $id = $_SESSION['id_user'];
    $sql = "SELECT * FROM users where id_user = '$id' and reset_token = '$code';";
    $result = $conn->query($sql);

    if($result->num_rows>0){
        $update = "UPDATE users set reset_token = NULL where id_user = '$id';";
        $conn->query($update);
        header("location:./changePass.php");
    }
}
?>
<body>
    
    <div class="background">
        <div class="glow"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <h1>Enter Verification Code</h1>
            <p>Please enter the 6-digit code we sent to your email.</p>

            <form action="checkToken.php" method="POST">
            <p id="error" class="error" style="color:red;"></p>
                <input type="text" id="code" name="code" maxlength="6" placeholder="Enter 6-digit code" required>
                <button id="login" onclick="validateCode()">Verify</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("code").addEventListener("input", function(event) {
            let input = event.target;
            if (input.value.length > 6) {
                input.value = input.value.slice(0, 6);
            }
        });

        function validateCode() {
            let code = document.getElementById("code").value.trim();
            let error = document.getElementById("error");

            if (code.length == 6 && !isNaN(code)) {
                document.querySelector('form').submit();
                return true;
            }
            else{
                error.textContent = "must be 6-digit";
                event.preventDefault();
                return false;
            }
        }
    </script>
</body>
</html>
