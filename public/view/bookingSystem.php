<?php
// bookAppointment.php
require '../../includes/connection.php';  // Include the database connection

// Handle Appointment Booking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_appointment'])) {
    $doctor_id = $_POST['doctor_id'];
    $patient_id = $_POST['patient_id'];
    $slot_time = $_POST['slot_time'];
    $date = $_POST['date'];

    // Check if the slot is available (is_booked == 0)
    $query = "SELECT * FROM slot WHERE id_doctor = :doctor_id AND slot_time = :slot_time AND date = :date AND is_booked = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->bindParam(':slot_time', $slot_time);
    $stmt->bindParam(':date', $date);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Slot is available, let's book it
        $insertQuery = "INSERT INTO appointments (id_doctor, id_patient, slot_time, date) VALUES (:doctor_id, :patient_id, :slot_time, :date)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':doctor_id', $doctor_id);
        $insertStmt->bindParam(':patient_id', $patient_id);
        $insertStmt->bindParam(':slot_time', $slot_time);
        $insertStmt->bindParam(':date', $date);
        $insertStmt->execute();

        // Mark the slot as booked
        $updateQuery = "UPDATE slot SET is_booked = 1 WHERE id_doctor = :doctor_id AND slot_time = :slot_time AND date = :date";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':doctor_id', $doctor_id);
        $updateStmt->bindParam(':slot_time', $slot_time);
        $updateStmt->bindParam(':date', $date);
        $updateStmt->execute();

        echo "<div class='success-message'>Your appointment has been successfully booked!</div>";
    } else {
        echo "<div class='error-message'>This slot is already booked or unavailable.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <style>
        /* CSS Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="number"],
        input[type="time"],
        input[type="date"],
        button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .success-message, .error-message {
            padding: 10px;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
        }

        .error-message {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Book an Appointment</h1>
    <form method="POST" action="bookAppointment.php">
        <input type="hidden" name="book_appointment">
        <label for="doctor_id">Doctor ID:</label>
        <input type="number" name="doctor_id" required>

        <label for="patient_id">Patient ID:</label>
        <input type="number" name="patient_id" required>

        <label for="slot_time">Slot Time (HH:MM):</label>
        <input type="time" name="slot_time" required>

        <label for="date">Date (YYYY-MM-DD):</label>
        <input type="date" name="date" required>

        <button type="submit">Book Appointment</button>
    </form>
</div>

</body>
</html>
