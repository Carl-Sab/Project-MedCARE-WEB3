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
    <?php  include "../../includes/header.php"?> 
    <main>
<section id="blood-donation">
    <h2>Request Blood</h2>
    <p>Find donors with your blood type quickly and contact them directly via WhatsApp.</p>
    <button class="btn"><a href="requestBlood.php">View Compatible Donors</a></button>
</section>
<section id="blood-request">
    <h2>Blood Requests</h2>
    <p>Find requests with your blood type quickly and contact them directly via WhatsApp.</p>
    <button class="btn"><a href="donorRequest.php">View Requests</a></button>
</section>
        <section id="appointments">
            <h2>Consultation & Appointments</h2>
            <p>Request consultations, view time slots, and manage your bookings.</p>
            <button class="btn"><a href="doctorList.php">Book Now</a></button>
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