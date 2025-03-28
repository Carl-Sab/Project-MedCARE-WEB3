<!-- Change Password Page -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/changePass.css">
  <title>Change Password</title>
</head>
<body>
  <div class="background">
    <div class="glow"></div>
  </div>
  <div class="login-container">
    <div class="login-card">
      <h1>Change Password</h1>
      <p>Enter your current password and set a new one.</p>
      <form>
        <div class="input-wrapper">
          <input type="password" placeholder="New Password" id="new-password" required onblur="validatePass()">
          <button type="button" class="show-password" onclick="togglePassword('new-password')">&#128065;</button>
          <p id="pass1-error"></p>
        </div>
        <div class="input-wrapper">
          <input type="password" placeholder="Confirm New Password" id="confirm-password" required onblur="validateConfPass()">
          <button type="button" class="show-password" onclick="togglePassword('confirm-password')">&#128065;</button>
          <p id="confirm-password-error" ></p>
        </div>
        <button id="Change_Password">Change Password</button>
      </form>
    </div>
  </div>
  <script>
    function togglePassword(fieldId) {
      const field = document.getElementById(fieldId);
      field.type = field.type === 'password' ? 'text' : 'password';
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
doument.querySelector("#Change_Password").addEventListener("click", function (event) {
    let isPassValid = validatePass();
    let isConfPassValid = validateConfPass();

 
    if (!isPassValid || !isConfPassValid) {
        event.preventDefault(); 
    }
    else{
      document.querySelector("form").submit();
    }
});
  </script>
</body>
</html>