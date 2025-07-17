<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Panel</title>
    <link rel="stylesheet" href="../css/doctorPanel.css">
</head>
<body>
    <?php
        include "../../includes/security.php";
    include '../../includes/header.php';

    ?>
    <div class="container">
        <div class="card">
            <h2>Consultations</h2>
            <p>Chat with patients, view saved chat logs, and respond to consultation requests.</p>
            <button><a href="doctorChatSystem.php">View Consultations</a></button>
        </div>
        


<div class="card">
    <h2>View Your Statistics</h2>
    <p>Track your appointment history, patient visits, and performance metrics.</p>
    <button><a href="doctorStats.php" class="btn">View Statistics</a></button>
</div>


        <div class="card">
            <h2>Client List</h2>
            <p>View and manage your clients details and appointments.</p>
            <button><a href="doctorSelectClient.php">View Clients</a></button>
        </div>
                <div class="card">
            <h2>Schedule</h2>
            <p>View your weekly schedule.</p>
            <button><a href="doctorWeeklySchedule.php">View Schedule</a></button>
        </div>
    </div>
</body>
</html>