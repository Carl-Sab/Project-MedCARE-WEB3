<?php
session_start();
include "../../includes/connection.php";
include "../../includes/security.php";


$id_slot = $_POST['id_slot'];
$id_doctor = $_POST['id_doctor'];
$date = $_POST['date'];
$id_client = $_SESSION['id_user'];

// Check if slot is still available on that date
$stmt = $conn->prepare("
    SELECT * FROM appointments
    WHERE id_slot = ? AND id_doctor = ? AND date = ?
");
$stmt->bind_param("iis", $id_slot, $id_doctor, $date);
$stmt->execute();
$existing = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($existing) {
    die("Sorry, this slot is no longer available for the chosen date.");
}

// Insert new appointment
$stmt = $conn->prepare("
    INSERT INTO appointments (id_patient, id_doctor, id_slot, date, status)
    VALUES (?, ?, ?, ?, 'Booked')
");
$stmt->bind_param("iiis", $id_client, $id_doctor, $id_slot, $date);
$stmt->execute();
$stmt->close();

header("Location: confirmation.php");
exit;
