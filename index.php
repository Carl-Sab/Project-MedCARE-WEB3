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
 
<?php
include "includes/header.php";
echo "<style>.n1{display:flex}</style>";
?>
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
          <li>Chat consulting</li>
          <li>Booking an appointment with doctor</li>
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