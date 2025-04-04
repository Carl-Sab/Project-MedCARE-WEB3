<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MedCare - Healthcare Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="./public/css/index.css">
    <link rel="stylesheet" href="./public/css/footer.css">
    <style>
      
      header {
    background: linear-gradient(135deg, #00796b, #004d40);
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
}

header h1 {
    font-size: 36px;
}

nav {
    display: flex;
}

.menu-toggle {
    display: none;
    font-size: 30px;
    cursor: pointer;
    background: none;
    border: none;
    color: white;
}

nav a {
    color: #fff;
    text-decoration: none;
    margin: 0 15px;
    padding: 8px 16px;
    border-radius: 20px;
    transition: background 0.3s, color 0.3s;
}

nav a:hover {
    background: white;
    color: #004d40;
}

@media (max-width: 768px) {
    .menu-toggle {
        display: block;
    }

    nav {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 70px;
        left: 0;
        width: 100%;
        background: linear-gradient(81deg, #00796b, #004d40);
        text-align: center;
        padding: 10px 0;
        z-index: 99;
    }

    nav a {
        display: block;
        margin: 10px 0;
        font-size: 18px;
        padding: 12px 20px;
    }

    nav.active {
        display: flex;
    }

    header h1 {
        font-size: 28px;
    }
}

    </style>
  </head>
  <body>

  <header>
    <h1>MedCare</h1>
    <button class="menu-toggle" onclick="toggleMenu()">
      <i class="fas fa-bars"></i>
    </button>
    <nav id="menu">
      <a href="#features">Features</a>
      <a href="#about">About Us</a>
      <a href="#services">Services</a>
      <a href="public/view/login.php">Login</a>
    </nav>
  </header>

    <section class="intro">
    <img src="public\images\MedCare.jpg" alt="Medical Care">
    <div class="overlay">
      <h1>Welcome to MedCare</h1>
      <p>Your health is our priority. Join us to experience world-class medical care!</p>
      <a href="./public/view/signup.php">Join Us</a>
    </div>
    </section>
    <div class="container">
      <br><br>
    <section id="features">
      <h2 class="section-title">Our Features</h2>
      <div class="features">
        <div class="feature">
          <i class="fa-regular fa-bell icons"></i>
          <h2>Emergency Request</h2>
          <p>Quick reliable response to urgent medical needs.</p>
        </div>
        <div class="feature">
          <i class="fa-regular fa-message icons"></i>
          <h2>Chat Consulting</h2>
          <p>Instant consultations with healthcare professionals.</p>
        </div>
        <div class="feature">
          <i class="fa-regular fa-calendar icons"></i>
          <h2>Booking System</h2>
          <p>Appointment booking with doctors and specialists.</p>
        </div>
      </div>
    </section>
    <br><br><br>
      <section id="about" class="about-us">
        <h2 class="section-title">About Us</h2>
        <p>
          MedCare is an advanced healthcare management system designed to
          streamline medical services. It facilitates blood donation, emergency
          medical assistance, doctor consultations, clinic bookings, and test
          result management.
        </p>
      </section>
      <br><br><br>
      <section id="services" class="services">
        <h2 class="section-title">Our Services</h2>
        <p>
          From routine check-ups to specialized treatments, we offer a wide
          range of services...
        </p>
        <ul>
          <li>Lab Test Results</li>
          <li>Emergency Services</li>
          <li>chat consulting</li>
          <li>Boocking an appointment with doctor</li>
        </ul>
      </section>
    </div>

    <footer> 
      <?php include "./includes/footer.php";?>
    </footer>
  </body>
  <script>
    function toggleMenu() {
      const nav = document.getElementById("menu");
      nav.classList.toggle("active");
    }
  </script>
</html>
