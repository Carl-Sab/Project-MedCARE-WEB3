<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/adminPanel.css">

<?php
session_start();
$username = $_SESSION['Uname'];
?>
  <title>Admin Panel</title>

</head>
<body>
  <?php
  include "../../includes/header.php";
  echo "<style>.n2{display:flex}</style>";
  ?>
  <div class="container">
    <div class="card" id="dashboard">
      <h2>Dashboard</h2>
      <p>View reports, statistics, and manage platform activity.</p>
      <button><a href="adminDashboard.php">Go to Dashboard</a></button>
    </div>

    <div class="card" id="blood-donation">
      <h2>Blood Donation System</h2>
      <p>Manage blood donors and requests.</p>
      <button><a href="">Manage Donations</a></button>
    </div>

    <div class="card" id="emergency">
      <h2>Emergency Requests</h2>
      <p>View and assign urgent service requests.</p>
      <button><a href="">Manage Requests</a></button>
    </div>

    <div class="card" id="chat">
      <h2>Chat System</h2>
      <p>Monitor chat logs and consultations.</p>
      <button><a href="">View Chats</a></button>
    </div>

    <div class="card" id="appointments">
      <h2>Doctor Booking</h2>
      <p>Track and manage doctor appointments.</p>
      <button><a href="">Manage Appointments</a></button>
    </div>
  </div>
  <footer>
    
  </footer>
</body>
</html>

