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
      <form>
        <input type="text" placeholder="Username" autocomplete="off" required>
        <div class="input-wrapper">
          <input type="password" id="password" placeholder="Password" autocomplete="off" required>
          <button type="button" class="show-password" onclick="togglePassword()">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <a href="#" class="forgot-password">Forgot Password?</a>
        <button id="login" type="submit"><a href="login.html">Log In</a></button>
      </form>
      <div class="no-account">
        Don't have an account? <a href="./view/signup.php" class="signup-link">Sign Up</a>
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
