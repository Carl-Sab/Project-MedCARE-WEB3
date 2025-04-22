<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/adminPanel.css">

<?php
?>
  <title>Admin Panel</title>

</head>
<body>
  <?php
  include "../../includes/header.php";
  echo "<style>.n2{display:flex}</style>";
  ?>
  <br><br>
  <div class="container">
    <div class="card" id="dashboard">
      <h2>Statistics</h2>
      <p>View statistics, and tracking payment and profit</p>
      <button><a href="adminStats.php">Go to Dashboard</a></button>
    </div>

    <div class="card" id="blood-donation">
      <h2>Blood Donation System</h2>
      <p>Manage blood donors and requests.</p>
      <button><a href="adminBloodDonation.php">Manage Donations</a></button>
    </div>

    <div class="card" id="emergency">
      <h2>Emergency Requests</h2>
      <p>View and assign urgent service requests.</p>
      <button><a href="adminEmergency.php">Manage Requests</a></button>
    </div>

    <div class="card" id="chat">
      <h2>Chat Review</h2>
      <p>Monitor chat review and consultations.</p>
      <button><a href="adminChatReview.php">Check Reviews</a></button>
    </div>

    <div class="card" id="appointments">
      <h2>Doctor schedule </h2>
      <p>Track and manage doctor appointments.</p>
      <button><a href="">Manage schedule</a></button>
    </div>
    
    <div class="card" id="userManage">
    <h2>Manage Users</h2>
    <p>Control user roles, permissions, and activity.</p>
    <button><a href="adminManageUser.php">Manage Users</a></button>
  </div>

  <div class="card" id="jobApply">
    <h2>Job apply</h2>
    <p>getting employement request accept/decline</p>
    <button><a href="#">check requests</a></button>
  </div>

  <div class="card" id="Reports">
    <h2>Reports</h2>
    <p>tracking Reports and help users with their case</p>
    <button><a href="adminReport.php">check report</a></button>
  </div>

  <div class="card" id="testResult">
    <h2>Test Result</h2>
    <p>double check on test result for prevending problems</p>
    <button><a href="#">check result</a></button>
  </div>
  </div>
  <footer>
    
  </footer>
</body>
</html>

