<?php
session_start();
include "../../includes/connection.php";
include "../../includes/security.php";


$id_doctor = $_GET['id_doctor'];
$id_client = $_SESSION['id_user']; // Assuming client is logged in

// Get doctor name
$stmt = $conn->prepare("SELECT user_name FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_doctor);
$stmt->execute();
$doctor = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bookAppointment.css">

    <title>Document</title>

</head>
<body>
    <?php include "../../includes/header.php" ?>
    <div id="container">
    <h2>Book Appointment with Dr. <?= htmlspecialchars($doctor['user_name']) ?></h2>
<form method="POST" action="submitAppointment.php">
    <input type="hidden" name="id_doctor" value="<?= $id_doctor ?>">

    <label>Select Date:</label>
    <input type="date" name="date" id="datePicker" required min="<?= date('Y-m-d') ?>">

    <div id="slotContainer"></div>

    <button type="submit">Book Appointment</button>
</form>
</div>
</body>
</html>


<script>
// Fetch available slots when date changes
document.getElementById('datePicker').addEventListener('change', function () {
    const date = this.value;
    const doctorId = <?= $id_doctor ?>;

    fetch(`getSlots.php?id_doctor=${doctorId}&date=${date}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('slotContainer').innerHTML = data;
        });
});
</script>
