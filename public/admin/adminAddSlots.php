<?php
// adminManageSlots.php
require '../../includes/connection.php';  // Include the database connection

// Handle Slot Creation (Admin adding slots for doctors)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_slots'])) {
    $doctor_id = $_POST['doctor_id'];
    $start_hour = $_POST['start_hour'];
    $end_hour = $_POST['end_hour'];
    $date = $_POST['date']; // Date for the slots

    // Loop through each hour to create slots
    for ($hour = strtotime($start_hour); $hour < strtotime($end_hour); $hour = strtotime('+1 hour', $hour)) {
        $slot_time = date("H:i", $hour);  // Format time as "H:i"
        
        // Insert slot into the database
        $query = "INSERT INTO slot (id_doctor, slot_time, date, is_booked) VALUES (:doctor_id, :slot_time, :date, 0)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':slot_time', $slot_time);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
    }
    echo "<div class='success-message'>Slots have been successfully added!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Slots</title>
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

        .success-message {
            padding: 10px;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            background-color: #4CAF50;
            color: white;
        }

        .error-message {
            padding: 10px;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin - Add Slots for Doctor</h1>
    <form method="POST" action="adminManageSlots.php">
        <input type="hidden" name="add_slots">
        <label for="doctor_id">Doctor ID:</label>
        <input type="number" name="doctor_id" required>

        <label for="start_hour">Start Hour:</label>
        <input type="time" name="start_hour" required>

        <label for="end_hour">End Hour:</label>
        <input type="time" name="end_hour" required>

        <label for="date">Date (YYYY-MM-DD):</label>
        <input type="date" name="date" required>

        <button type="submit">Add Slots</button>
    </form>
</div>

</body>
</html>
