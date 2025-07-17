<?php
include "../../includes/security.php";
include "../../includes/connection.php";

$id_doctor = $_SESSION['id_user'];

// Calculate Monday–Sunday dates for the current week
$today = new DateTime();
$dayOfWeek = (int)$today->format('N'); // 1=Monday
$monday = new DateTime($today->format('Y-m-d'));
$monday->modify('-' . ($dayOfWeek - 1) . ' days');
$sunday = new DateTime($monday->format('Y-m-d'));
$sunday->modify('+6 days');

$mondayStr = $monday->format('Y-m-d');
$sundayStr = $sunday->format('Y-m-d');

// Fetch all time slots for this doctor
$stmt = $conn->prepare("SELECT * FROM time_slots WHERE id_doctor = ? ORDER BY start_time");
$stmt->bind_param("i", $id_doctor);
$stmt->execute();
$slotsResult = $stmt->get_result();
$slots = $slotsResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch booked appointments this week
$stmt = $conn->prepare("
    SELECT a.date, a.id_slot, u.user_name AS patient_name
    FROM appointments a
    JOIN users u ON a.id_patient = u.id_user
    WHERE a.id_doctor = ?
    AND a.date BETWEEN ? AND ?
");
$stmt->bind_param("iss", $id_doctor, $mondayStr, $sundayStr);
$stmt->execute();
$result = $stmt->get_result();

// Build map: $appointments[date][id_slot] = patient_name
$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[$row['date']][$row['id_slot']] = $row['patient_name'];
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Weekly Appointment Schedule</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #f2f2f2; }
        .booked { background: #dff0d8; }
    </style>
</head>
<body>
<?php include "../../includes/header.php"; ?>

<div class="schedule-container">
    <h2>Weekly Appointment Schedule</h2>
    <p><?= date('M d', strtotime($mondayStr)) ?> - <?= date('M d, Y', strtotime($sundayStr)) ?></p>

    <?php if (!empty($slots)): ?>
    <table>
        <thead>
            <tr>
                <th>Time Slot</th>
                <?php for ($i = 0; $i < 7; $i++): 
                    $dateStr = date('Y-m-d', strtotime($mondayStr . " +$i days")); ?>
                    <th><?= date('D<br>M d', strtotime($dateStr)) ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($slots as $slot): ?>
            <tr>
                <td><?= date('H:i', strtotime($slot['start_time'])) ?> - <?= date('H:i', strtotime($slot['End_time'])) ?></td>
                <?php for ($i = 0; $i < 7; $i++): 
                    $dateStr = date('Y-m-d', strtotime($mondayStr . " +$i days"));
                    $patient = $appointments[$dateStr][$slot['id_slot']] ?? ''; ?>
                    <td class="<?= $patient ? 'booked' : '' ?>">
                        <?= htmlspecialchars($patient) ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No time slots defined for this doctor.</p>
    <?php endif; ?>
</div>
</body>
</html>
