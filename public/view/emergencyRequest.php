<?php
session_start();
include '../../includes/connection.php';

// Assuming user is logged in and session contains user id
$id_client = $_SESSION['id_user']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reason = $_POST['reason'];
    $date_emergency = date("Y-m-d H:i:s");
    $status = 'Pending';

    $stmt = $conn->prepare("INSERT INTO emergency (id_client, reason, date_emergency, stats) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id_client, $reason, $date_emergency, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Emergency request submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Emergency Request</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="../css/emergencyRequest.css">
</head>
<body>
    <?php include "../../includes/header.php";  ?>
    <div class="container">
        <h2>Submit Emergency Request</h2>
        <form method="POST" action="">
            <label for="reason">Reason for Emergency:</label><br>
            <textarea name="reason" id="reason" rows="5" required></textarea><br><br>
            <input type="submit" value="Submit Request">
        </form>
    </div>
</body>
</html>