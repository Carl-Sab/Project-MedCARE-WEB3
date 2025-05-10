<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/changePass.css">
  <title>Change Password</title>
</head>
<?php
include "../../includes/connection.php";
session_start();

if (isset($_POST['pass']) && isset($_SESSION['id_user'])) {
    $pass = $_POST['pass'];
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
    $id = $_SESSION['id_user'];

    // Secure UPDATE statement
    $update = $conn->prepare("UPDATE users SET pass = ? WHERE id_user = ?");
    $update->bind_param("si", $hashedPass, $id);
    $update->execute();
    $update->close();

    // Secure SELECT statement
    $select = $conn->prepare("SELECT role FROM users WHERE id_user = ?");
    $select->bind_param("i", $id);
    $select->execute();
    $result = $select->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row['role'];

        if ($role === 'admin') {
            header("Location: ../admin/adminPanel.php");
        } else if ($role === 'doctor') {
            header("Location: ../doctor/doctorPanel.php");
        } else {
            header("Location: ./homepage.php");
        }
        exit();
    }

    $select->close();
}
?>

<body>
  <div class="background">
    <div class="glow"></div>
  </div>
  <div class="login-container">
    <div class="login-card">
      <h1>Change Password</h1>
      <span>Enter your current password and set a new one.</span>
      <form action="changePass.php" method="POST">
        <div class="input-wrapper">
          <input type="password" placeholder="New Password" id="new-password" required onblur="validatePass()">
          <button type="button" class="show-password" onclick="togglePassword(1)"><i class="fas fa-eye"></i></button>
        </div>
        <p id="pass1-error"></p>
        <div class="input-wrapper">
          <input type="password" placeholder="Confirm New Password" name="pass" id="confirm-password" required onblur="validateConfPass()">
          <button type="button" class="show-password" onclick="togglePassword(2)"><i class="fas fa-eye"></i></button>
        </div>
        <p id="confirm-password-error"></p>

        <button id="Change_Password">Change Password</button>
      </form>
    </div>
  </div>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script>

function togglePassword(fieldId) {
    let passwordField = document.getElementById(fieldId === 1 ? 'new-password' : 'confirm-password');
    let icon = passwordField.nextElementSibling.querySelector("i");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}

function validatePass() {
    let pass = document.getElementById("new-password").value.trim();
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
    let pass = document.getElementById("new-password").value.trim();
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

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("#Change_Password").addEventListener("click", function (event) {
        let isPassValid = validatePass();
        let isConfPassValid = validateConfPass();

        if (!isPassValid || !isConfPassValid) {
            event.preventDefault();
        } else {
            document.querySelector("form").submit();
        }
    });
});

  </script>
</body>
</html>
