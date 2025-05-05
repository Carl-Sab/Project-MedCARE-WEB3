<?php
require '../../includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $doctor_id = intval($_POST['doctor_id']);
    $patient_id = 1; // Replace with logged-in patient id

    // Check if slot already booked
    $check_sql = "SELECT is_booked FROM time_slots WHERE id_doctor = $doctor_id AND start_time = '$start_time'";
    $check_result = $conn->query($check_sql);

    if ($check_result && $check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        if ($row['is_booked']) {
            echo "This slot is already booked.";
        } else {
            // Mark slot as booked
            $update_sql = "UPDATE time_slots SET is_booked = 1 WHERE id_doctor = $doctor_id AND start_time = '$start_time'";
            $conn->query($update_sql);

            // Insert appointment
            $conn->query("INSERT INTO appointments (id_patient, id_doctor, id_slot, status) VALUES ($patient_id, $doctor_id, 0, 'Booked')");

            echo "Slot booked successfully";
        }
    } else {
        // If slot doesn't exist, insert it and mark booked
        $insert_slot = "INSERT INTO time_slots (id_doctor, start_time, End_time, is_booked) VALUES ($doctor_id, '$start_time', '$end_time', 1)";
        if ($conn->query($insert_slot)) {
            $conn->query("INSERT INTO appointments (id_patient, id_doctor, id_slot, status) VALUES ($patient_id, $doctor_id, " . $conn->insert_id . ", 'Booked')");
            echo "Slot booked successfully";
        } else {
            echo "Failed to book slot.";
        }
    }
} else {
    echo "Invalid request.";
}
?>
