<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <link rel="stylesheet" href="../css/signup.css">
  </head>

  <?php
  include "../../includes/security.php";
include "../../includes/connection.php";


if(isset($_POST['uname'],$_POST['mail'],$_POST['tel'],$_POST['pass'])){
  $name = $_POST['uname'];
  $email = $_POST['mail'];
  $tel = $_POST['tel'];
  $pass = $_POST['pass'];
  $hashedPass=password_hash($pass,PASSWORD_DEFAULT);
  $insert = "INSERT INTO users (`user_name`,`email`,`tel`,`pass`,`role`)VALUES('$name','$email','$tel','$hashedPass','client');";
  $conn ->query($insert);

  $select = "SELECT * from users where user_name = '$name' && email = '$email';";
  $result = $conn->query($select);


    $select = $conn->prepare("SELECT * FROM users WHERE user_name = ? AND email = ?");
    if ($select) {
        $select->bind_param("ss", $name, $email);
        $select->execute();
        $result = $select->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['id_user'] = $row["id_user"];
            $_SESSION['Uname'] = $name;
            setcookie("id_user", $row['id_user'], time() + (86400 * 30), "/"); // 30 days
            setcookie("Uname",$uname, time() + (86400 * 30), "/"); // 30 days
            header("location:infos.php");
            exit();
        }

        $select->close();
    } else {
        die("Error preparing select statement: " . $conn->error);
    }
}

?>
  <body>
    <div class="background">
      <div class="glow"></div>
    </div>
    <div class="signup-container">
      <div class="signup-card">
        
        <h1>Create Account</h1>
        <p>Sign up to get started</p>
        <form action="signup.php" method="POST">
          <input type="text" placeholder="Username" name="uname" id="name" onblur="validateName()" required autocomplete="off"/>
          <p id="name-error" style="color:rgb(169, 16, 16); font-size: 14px; margin: 5px 0 0"></p>

          <input type="email" placeholder="Email" id="mail" name="mail" onblur="validateMail()" required autocomplete="off"/>
          <p id="mail-error" style="color: rgb(169, 16, 16); font-size: 14px; margin: 5px 0 0"></p>

          <input type="text" placeholder="Tel" id="tel" name="tel" onblur="validateMail()" required autocomplete="off"/>


          <div class="input-wrapper">
            <input type="password" id="password" placeholder="Password" required onblur="validatePass()" autocomplete="off"/>
            <button type="button" class="show-password" onclick="togglePassword(1)"><i class="fas fa-eye"></i></button>
          </div>

          <p id="pass1-error" style="color: rgb(169, 16, 16); font-size: 14px; margin: 5px 0 0"></p>
          <div class="input-wrapper">
            <input type="password" id="confirm-password" placeholder="Confirm Password" name="pass" required onblur="validateConfPass()" autocomplete="off"/>
            <button type="button" class="show-password" onclick="togglePassword(2)"><i class="fas fa-eye"></i></button>
          </div>
          <p id="confirm-password-error" style="color: rgb(169, 16, 16); font-size: 14px; margin: 5px 0 0"></p>

          <button id="signup" onclick="Validation()"> Sign Up </button>

        </form>
        <div class="already-account"> Already have an account?<a href="./login.php" class="login-link">Log In</a></div>
      </div>
    </div>
    <script>
function togglePassword(n) {
    let passwordField = n === 1 ? document.getElementById("password") : document.getElementById("confirm-password");
    let icon = document.querySelectorAll(".show-password i")[n - 1];

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

function validateName() {
    let name = document.getElementById("name").value.trim();
    let errorMessage = document.getElementById("name-error");
    let namePattern = /^[A-Za-z]+$/;

    if (name.length > 0 && !namePattern.test(name)) {
        errorMessage.textContent = "Name can only contain letters.";
        return false;
    } else {
        errorMessage.textContent = "";
        return true;
    }
}

function validateMail() {
    let mail = document.getElementById("mail").value.trim();
    let errorMail = document.getElementById("mail-error");
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (mail.length > 0 && !emailPattern.test(mail)) {
        errorMail.textContent = "Enter a valid email address.";
        return false;
    } else {
        errorMail.textContent = "";
        return true;
    }
}

function validatePass() {
    let pass = document.getElementById("password").value.trim();
    let errorPass = document.getElementById("pass1-error");
    let passPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (!passPattern.test(pass)) {
        errorPass.textContent = "Password must be at least 8 characters, include an uppercase letter, a lowercase letter, a number, and a special character (@$!%*?&).";
        return false;
    } else {
        errorPass.textContent = "";
        return true;
    }
}

function validateConfPass() {
    let pass = document.getElementById("password").value.trim();
    let confPass = document.getElementById("confirm-password").value.trim();
    let confirmError = document.getElementById("confirm-password-error");

    if (confPass.length > 0 && confPass !== pass) {
        confirmError.textContent = "Passwords do not match. Please try again.";
        return false;
    } else {
        confirmError.textContent = "";
        return true;
    }
}

document.querySelector("#signup").addEventListener("click", function (event) {
    let isNameValid = validateName();
    let isMailValid = validateMail();
    let isPassValid = validatePass();
    let isConfPassValid = validateConfPass();

    if (!isNameValid || !isMailValid || !isPassValid || !isConfPassValid) {
        event.preventDefault(); 
    } else {
        document.querySelector("form").submit();
    }
});
</script>

  </body>
</html>
