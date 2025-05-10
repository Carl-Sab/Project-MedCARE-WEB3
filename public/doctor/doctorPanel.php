<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Panel</title>
    <link rel="stylesheet" href="../css/doctorPanel.css">
</head>
<body>
    <?php include '../../includes/header.php';?>
    <div class="container">
        <div class="card">
            <h2>Consultations</h2>
            <p>Chat with patients, view saved chat logs, and respond to consultation requests.</p>
            <button><a href="doctorChatSystem.php">View Consultations</a></button>
        </div>
        
        <div class="card">
            <h2>Upload Test Results</h2>
            <p>Upload and manage patient test results securely.</p>
            <button><a href="#">Upload Results</a></button>
        </div>

<div class="card">
    <h2>View Your Statistics</h2>
    <p>Track your appointment history, patient visits, and performance metrics.</p>
    <button><a href="doctorStats.php" class="btn">View Statistics</a></button>
</div>


        <div class="card">
            <h2>Profile</h2>
            <p>Manage your profile details and availability.</p>
            <button><a href="#">Edit Profile</a></button>
        </div>
    </div>
</body>
</html>