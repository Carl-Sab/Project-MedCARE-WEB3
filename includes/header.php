<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./public/css/header.css">
</head>
<body>
  <h1>MedCare</h1>
        <button class="menu-toggle" onclick="toggleMenu()">
          <i class="fas fa-bars"></i>
        </button>
        <nav id="menu">
          <a href="#features">Features</a>
          <a href="#about">About Us</a>
          <a href="#services">Services</a>
          <a href="public\view\login.php">Login</a>
        </nav>
</body>
<script>
    const menuToggle = document.querySelector(".menu-toggle");
    const nav = document.querySelector("nav");
    menuToggle.addEventListener("click", function () {
      nav.classList.toggle("active");
});
  </script>
</html>
