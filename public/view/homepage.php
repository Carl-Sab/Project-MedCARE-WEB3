<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>MedCare Home</title>
    <link rel="stylesheet" href="../css/homepage.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Welcome to the enhanced MedCare homepage!');
        });
    </script>
</head>
<?php

session_start();
include "../../includes/connection.php";
$Uname = $_SESSION['Uname'];
$id = $_SESSION['id_user'];

?>
<body>
    <header>
        <h1>MedCare</h1>
        <nav>
            <ul>
                <li><a href="#blood-donation">Blood Donation</a></li>
                <li><a href="#appointments">Appointments</a></li>
                <li><a href="#emergency-requests">Emergency</a></li>

            </ul>
        </nav>
    </header>
    <main>
        <section id="blood-donation">
            <h2>Blood Donation System</h2>
            <p>Register as a donor, check your blood type, and receive donation requests.</p>
            <button class="btn">Learn More</button>
        </section>
        <section id="appointments">
            <h2>Consultation & Appointments</h2>
            <p>Request consultations, view time slots, and manage your bookings.</p>
            <button class="btn"><a href="doctorSelect.php">Book Now</a></button>
        </section>
        <section id="emergency-requests">
            <h2>Emergency Requests</h2>
            <p>Request home visits or emergency help from our team.</p>
            <button class="btn"><a href="emergencyRequest.php">Get Help</a></button>
        </section>

    </main>
    <footer>
    <?php include "../../includes/footer.php";?>
    </footer>
</body>
</html>