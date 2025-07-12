<?php
include "../../includes/connection.php";
include "../../includes/security.php";


$id_doctor = $_GET['id_doctor'];
$date = $_GET['date'];

// Get all available time slots that are not already booked
$stmt = $conn->prepare("
    SELECT ts.id_slot, ts.start_time, ts.end_time
    FROM time_slots ts
    WHERE ts.id_doctor = ?
    AND ts.id_slot NOT IN (
        SELECT id_slot FROM appointments
        WHERE id_doctor = ? AND date = ?
    )
");

if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("iis", $id_doctor, $id_doctor, $date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No available slots for this date.";
} else {
    echo "<label>Select Slot:</label><select name='id_slot' required>";
    while ($row = $result->fetch_assoc()) {
        $start = date("H:i", strtotime($row['start_time']));
        $end = date("H:i", strtotime($row['end_time']));
        echo "<option value='{$row['id_slot']}'>{$start} - {$end}</option>";
    }
    echo "</select>";
}

$stmt->close();
?>
