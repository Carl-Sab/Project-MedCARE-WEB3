<?php
session_start();
include "../../includes/connection.php";
include "../../includes/security.php";


$id_doctor = 1; // For testing

// Get current date
$today = new DateTime();
$dayOfWeek = (int)$today->format('N'); // 1 (Monday) to 7 (Sunday)

// Calculate Monday and Sunday of this week
$monday = clone $today;
$monday->modify('-' . ($dayOfWeek - 1) . ' days');
$sunday = clone $monday;
$sunday->modify('+6 days');

$startWeek = $monday->format('Y-m-d') . ' 00:00:00';
$endWeek = $sunday->format('Y-m-d') . ' 23:59:59';

// Prepare query with patient name
$stmt = $conn->prepare("
    SELECT a.appointment_id, a.id_doctor, u.user_name AS doctor_name, a.date, ts.start_time, ts.end_time,
           p.user_name AS patient_name
    FROM appointments a
    JOIN users u ON a.id_doctor = u.id_user
    JOIN users p ON a.id_patient = p.id_user
    JOIN time_slots ts ON a.id_slot = ts.id_slot
    WHERE a.id_doctor = ?
      AND a.date BETWEEN ? AND ?
    ORDER BY a.date, ts.start_time
");

if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$mondayStr = $monday->format('Y-m-d');
$sundayStr = $sunday->format('Y-m-d');
$stmt->bind_param("sss", $id_doctor, $mondayStr, $sundayStr);
$stmt->execute();
$result = $stmt->get_result();

$appointments = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Weekly Schedule</title>
    <link rel="stylesheet" href="../css/doctorWeeklySchedule.css?v=1">
</head>
<body>
<?php include "../../includes/header.php"; ?>
<div class="schedule-container">
    <h2>Weekly Appointment Schedule</h2>
    <p><?= date('M d', strtotime($mondayStr)) ?> - <?= date('M d, Y', strtotime($sundayStr)) ?></p>

    <?php if (!empty($appointments)): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments as $row): ?>
                <tr>
                    <td><?= date('l, M d', strtotime($row['date'])) ?></td>
                    <td><?= date('H:i', strtotime($row['start_time'])) ?> - <?= date('H:i', strtotime($row['end_time'])) ?></td>
                    <td><?= htmlspecialchars($row['patient_name']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No appointments scheduled this week.</p>
    <?php endif; ?>
</div>
</body>
</html>
