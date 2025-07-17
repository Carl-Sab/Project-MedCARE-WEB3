<?php
include "../../includes/security.php";
include "../../includes/connection.php";

$msg = "";
$remembered_username = isset($_COOKIE['Uname']) ? $_COOKIE['Uname'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Uname'], $_POST['pass'])) {
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
                $_SESSION["role"] = $row['role'];

                if (isset($_POST['remember'])) {
                    setcookie("id_user", $row['id_user'], time() + (86400 * 30), "/");
                    setcookie("Uname", $row['user_name'], time() + (86400 * 30), "/");
                    setcookie("role", $row['role'], time() + (86400 * 30), "/");
                }

                if ($row['role'] === 'admin') {
                    header("Location: ../admin/adminPanel.php");
                } elseif ($row['role'] === 'doctor') {
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
        $msg = "Database error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <input type="text" placeholder="Username/Email" name="Uname" autocomplete="off" value="<?php echo htmlspecialchars($remembered_username); ?>" required>
        <div class="input-wrapper">
          <input type="password" id="password" placeholder="Password" name="pass" autocomplete="off" required>
          <button type="button" class="show-password" onclick="togglePassword()">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <a href="./forgotPass.php" class="forgot-password">Forgot Password?</a>
        <label class="remember-me">
          <input type="checkbox" name="remember" <?php echo isset($_COOKIE['Uname']) ? "checked" : ""; ?>>
          <span>Remember Me</span>
        </label>
        <button id="login" type="submit">Log In</button>
      </form>

      <div class="no-account">
        Don't have an account? <a href="./signup.php" class="signup-link">Sign Up</a>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const password = document.getElementById("password");
      const icon = document.querySelector(".show-password i");
      if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        password.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
      }
    }
  </script>
</body>
</html>
