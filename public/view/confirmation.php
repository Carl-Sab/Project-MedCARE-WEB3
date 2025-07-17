<?php
    include "../../includes/security.php";
include "../../includes/connection.php";

$id_client = $_SESSION['id_user'];

$stmt = $conn->prepare("
    SELECT a.appointment_id, a.id_doctor, u.user_name AS doctor_name, d.booking_amount, a.date, ts.start_time, ts.end_time
    FROM appointments a
    JOIN users u ON a.id_doctor = u.id_user
    JOIN doctor d ON d.id_doctor = a.id_doctor
    JOIN time_slots ts ON a.id_slot = ts.id_slot
    WHERE a.id_patient = ?
    ORDER BY a.appointment_id DESC
    LIMIT 1
");


if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $id_client);
$stmt->execute();
$appointment = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$appointment) {
    echo "No recent appointment found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/confirmation.css">
    <title>Document</title>
</head>
<body>
    <?php include "../../includes/header.php";

    ?>
<div id="main-content">
    <div id="container">
        <div>
            <h2>Appointment Confirmed!</h2>
            <p>Thank you for booking your appointment.</p>
            <p><strong>Doctor:</strong> Dr. <?= htmlspecialchars($appointment['doctor_name']) ?></p>
            <p><strong>Date & Time:</strong> <?= htmlspecialchars($appointment['date']) ?>, <?= date('H:i', strtotime($appointment['start_time'])) ?> - <?= date('H:i', strtotime($appointment['end_time'])) ?></p>
            <p><strong>Booking Fee:</strong> $<?= number_format($appointment['booking_amount'], 2) ?></p>

            <a href="homepage.php">
                back to homepage
            </a>
        </div>
    </div>
</div>
</body>
</html>
