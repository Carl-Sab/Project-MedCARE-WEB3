<?php
session_start();
include "../../includes/connection.php";
include "../../includes/security.php";


$msg = "";
$remembered_username = isset($_COOKIE['Uname']) ? $_COOKIE['Uname'] : '';

if (isset($_POST['Uname']) && isset($_POST['pass'])) {
    $uname = $_POST['Uname'];
    $pass = $_POST['pass'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = ?");
    if ($stmt) {
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($pass, $row['pass'])) {
                $_SESSION["id_user"] = $row['id_user'];
                $_SESSION["Uname"] = $row['user_name'];

                if (isset($_POST['remember'])) {
                    setcookie("id_user", $row['id_user'], time() + (86400 * 30), "/"); // 30 days
                    setcookie("Uname", $row['user_name'], time() + (86400 * 30), "/"); // 30 days

                }
                if ($row['role'] == 'admin') {
                    header("Location: ../admin/adminPanel.php");
                } else if ($row['role'] == 'doctor') {
                    header("Location: ../doctor/doctorPanel.php");
                } else {
                    header("Location: ./homepage.php");
                }
                exit();
            } else {
                $msg = "Wrong username or password";
            }
        } else {
            $msg = "Wrong username or password";
        }

        $stmt->close();
    } else {
        $msg = "Something went wrong with the database connection.";
    }
}
?>
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
<body>
  <div class="background">
    <div class="glow"></div>
  </div>

  <div class="login-container">
    <div class="login-card">
      <h1>Welcome Back</h1>
      <p>Login to your account</p>

      <form action="./login.php" method="POST">
        <p style="color: red;"><?php echo htmlspecialchars($msg); ?></p>

        <input type="text" placeholder="Username" name="Uname" value="<?php echo htmlspecialchars($remembered_username); ?>" autocomplete="off" required>

        <div class="input-wrapper">
          <input type="password" id="password" placeholder="Password" name="pass" autocomplete="off" required>
          <button type="button" class="show-password" onclick="togglePassword()">
            <i class="fas fa-eye"></i>
          </button>
        </div>

        <label class="remember-me">
          <input type="checkbox" name="remember" <?php if (isset($_COOKIE['username'])) echo "checked"; ?>>
          <span>Remember Me</span>
        </label>

        <a href="./forgotPass.php" class="forgot-password">Forgot Password?</a>
        <button id="login" type="submit">Log In</button>
      </form>

      <div class="no-account">
        Don't have an account? <a href="./signup.php" class="signup-link">Sign Up</a>
      </div>
    </div>
  </div>

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
</body>
</html>
