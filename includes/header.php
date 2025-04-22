<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Glassmorphism Navbar HTML CSS JS | Codehal</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
       @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  min-height: 100vh;
  
}
.header {
  position:relative;
  top: 0;
  left: 0;
  width: 100%;
  padding: 20px 100px;
  background: linear-gradient(135deg, #00796b, #004d40);
  display: flex;
  justify-content: space-between;
  align-items: center;
  backdrop-filter: blur(10px);
  border-bottom: 2px solid rgba(255, 255, 255, 0.2);
  z-index: 100;
}
.header::before {
  content: "";
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    90deg,
    transparent,
    rgba(255, 255, 255, 0.4),
    transparent
  );
  transition: 0.5s;
}

.logo {
  color: #fff;
  font-size: 25px;
  text-decoration: none;
  font-weight: 600;
}

.navbar a {
  position: relative;
  display: inline-block;
  color: #fff;
  font-size: 18px;
  text-decoration: none;
  margin-left: 35px;
  transition: color 0.3s ease;
  padding: 4px 0; 
}

.navbar a::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  height: 2px;
  width: 0%;
  background-color:white;
  transition: width 0.3s ease;
}

.navbar a:hover::after {
  width: 100%;
}


#menu-icon {
  font-size: 36px;
  color: #fff;
  display: none;
  cursor: pointer;
}
/* BREAKPOINTS */
@media (max-width: 992px) {
  .header {
    padding: 1.25rem 4%;
    width: 100%;
  }
}
@media (max-width: 768px) {
  #menu-icon {
    display: block;
  }
  .navbar {
    position:absolute;
    top: 100%;
    left: 0;
    width: 100%;
    padding: 0.5rem 4%;
    display: none;
  }
  .navbar.active {
    display: block;
  }
  .navbar a {
    display:block;
    /* margin: 1.5rem 0; */
    margin:1.5rem 0 -0.5rem 0;

  }
  .nav-bg {
    position: absolute;
    top: 79px;
    left: 0;
    width: 100%;
    height: 295px;
    background: linear-gradient(135deg, #00796b, #004d40);
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    z-index: 99;
    display: none;
  }
  .nav-bg.active {
    display: block;
  }
} 
    </style>
</head>
<body>
<header class="header">
    <a href="#" class="logo">MedCare</a>
    <i class='bx bx-menu' id="menu-icon"></i>
    <nav class="navbar">
        <?php 
        $currentPage = basename($_SERVER['PHP_SELF']); 
        if ($currentPage == "index.php") {
            echo '
            <a href="#features">Features</a>
            <a href="#about">About Us</a>
            <a href="#services">Services</a>
            <a href="public/view/login.php">Login</a>';
        } elseif ($currentPage == "adminPanel.php") {
            echo '
            <a href="../public/view/logout.php">Logout</a>
            <a href="../public/view/homepage.php">Homepage</a>
            <a href="#doctor">Doctor</a>';
        }elseif($currentPage=="adminBloodDonation.php" || $currentPage=="adminChatReview.php" || $currentPage=="adminDashboard.php" || $currentPage=="adminEmergency.php" || $currentPage=="adminManageUser.php" || $currentPage=="adminReport.php" || $currentPage=="adminStats.php"){
          echo'
            <a href="../public/view/logout.php">Logout</a>
            <a href="../public/view/homepage.php">Homepage</a>
            <a href="#doctor">Doctor</a>
            <a href="adminPanel.php">back</a>';
        }
        ?>
    </nav>
<<<<<<< HEAD
  </header>
  <header class="header n2">
    <a href="#" class="logo">Admin Panel</a>
    <i class="bx bx-menu" id="menu-icon"></i>
    <nav class="navbar">

     <a href="../view/logout.php">Logout</a>
      <a href="../view/homepage.php">Homepage</a>
      <a href="#doctor">Doctor</a>

    </nav>
  </header>
  <header class="header n3">
    <a href="#" class="logo">Admin Panel</a>
    <i class="bx bx-menu" id="menu-icon"></i>
    <nav class="navbar">
     <a href="../view/logout.php">Logout</a>
      <a href="../view/homepage.php">Homepage</a>
      <a href="#doctor">Doctor</a>
      <a href="adminPanel.php">back</a>

    </nav>
  </header>

  <div class="nav-bg"></div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const menuIcon = document.querySelector('#menu-icon');
      const navbar = document.querySelector('.navbar');
      const navbg = document.querySelector('.nav-bg');

      menuIcon.addEventListener('click', () => {
        menuIcon.classList.toggle('bx-x');
        navbar.classList.toggle('active');
        navbg.classList.toggle('active');
      });
    });
  </script>
=======
</header>
    <div class="nav-bg"></div>
    <script src="script.js"></script>
>>>>>>> 96438c41a85fdce63eea88ecc93b4cdab3a98869
</body>
<script>
    const menuIcon = document.querySelector('#menu-icon');
const navbar = document.querySelector('.navbar');
const navbg = document.querySelector('.nav-bg');
menuIcon.addEventListener('click', () => {
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active');
    navbg.classList.toggle('active');
});
</script>
</html>