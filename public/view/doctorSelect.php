<?php
require '../../includes/connection.php';

// Get all doctors
$sql = "SELECT id_user, user_name FROM users WHERE role = 'doctor'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Doctor</title>
    <style>
        body {
            background: linear-gradient(135deg, #00796b, #004d40);
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
        }
        .doctor-card {
            background: #00695c;
            margin: 20px auto;
            padding: 20px;
            border-radius: 12px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        a.button {
            display: inline-block;
            padding: 10px 20px;
            background: #004d40;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }
        a.button:hover {
            background: #00332a;
        }
    </style>
</head>
<body>
    <h1>Select a Doctor</h1>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="doctor-card">
            <h2><?php echo htmlspecialchars($row['user_name']); ?></h2>
            <a class="button" href="bookingSystem.php?doctor_id=<?php echo $row['id_user']; ?>">View Slots</a>
        </div>
    <?php endwhile; ?>
</body>
</html>
