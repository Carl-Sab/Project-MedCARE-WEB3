<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/login.css">

</head>
<?php
include "../../includes/connection.php";
session_start();
$msg ="";
if(isset($_POST['Uname'])&&isset($_POST['pass'])){
    $uname = $_POST['Uname'];
    $pass = $_POST['pass'];
    $sql = "SELECT * FROM users where user_name = '$uname';";
    $result = $conn->query($sql);

    if ($result->num_rows>0){
       $row = $result->fetch_assoc();
       $id = $row['id_user'];
       if(password_verify($pass,$row['pass'])){
       $_SESSION["id_user"] =$id;
       $_SESSION["Uname"] = $uname;

       if($row['role']=='admin'){
        header("location:../admin/adminPanel.php");
       }

       else if($row['role']=='doctor'){
        header("location:./doctorPanel.php");
       }
      }
       else{
        header("location:./homepage.php");
       }

    }
    else{
        $msg = "username not found.";
    }
}
?>
<body>
  <div class="background">
    <div class="glow"></div>
  </div>
  <div class="login-container">
    <div class="login-card">
      <h1>Welcome Back</h1>
      <p>Login to your account</p>

      <form action="./login.php" method="POST">

      <p style="color: red;"><?php echo (isset($msg)?$msg:"");?></p>
        <input type="text" placeholder="Username/Email" name="Uname" autocomplete="off" required>
        <div class="input-wrapper">
          <input type="password" id="password" placeholder="Password" name="pass" autocomplete="off" required>
          <button type="button" class="show-password" onclick="togglePassword()">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <a href="./forgotPass.php" class="forgot-password">Forgot Password?</a>
        <button id="login" type="submit">Log In</button>
      </form>
      <div class="no-account">
        Don't have an account? <a href="./signup.php" class="signup-link">Sign Up</a>
      </div>
    </div>
    
  </div>

  </body>
  <script>
    function togglePassword() {
      var password = document.getElementById("password");
      var icon = document.querySelector(".show-password i");
      if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        password.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>
</html>
