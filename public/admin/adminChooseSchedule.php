<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #00796b;
            color: white;
            text-align: center;
        }

        .schedule-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        select, input, button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: white;
            color: #00796b;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #004d40;
            color: white;
        }

        .result {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="schedule-container">
    <h2>Doctor's Weekly Schedule</h2>

    <form method="POST" action="">
        <label for="doctor">Choose a doctor:</label>
        <select id="doctor" name="doctor" required>
            <?php
            include "../../includes/connection.php";
            $query = "SELECT id_user, user_name FROM users WHERE role = 'doctor'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value=\"{$row['user_name']}\">Dr. " . htmlspecialchars($row['user_name']) . "</option>";
                }
            } else {
                echo "<option disabled>No doctors found</option>";
            }
            ?>
        </select>

        <label>Select time slot (applies Mon-Sun):</label>
        <input type="time" name="start_time" required>
        <input type="time" name="end_time" required>

        <button type="submit">Save Schedule</button>
    </form>

    <?php
    include "../../includes/connection.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $doctorName = $_POST['doctor'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $query = "SELECT id_user FROM users WHERE user_name = '$doctorName' AND role = 'doctor'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $doctorId = $row['id_user'];  
            if (!empty($start_time) && !empty($end_time)) {
                $stmt = $conn->prepare("INSERT INTO time_slots (id_doctor, start_time, end_time) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $doctorId, $start_time, $end_time);
                if ($stmt->execute()) {
                    echo "<div class='result'><p>Schedule saved successfully!</p></div>";
                } else {
                    echo "<div class='result'><p>Error saving schedule: " . $stmt->error . "</p></div>";
                }
                $stmt->close();
            } else {
                echo "<div class='result'><p>Please select both start and end time.</p></div>";
            }
        } else {
            echo "<div class='result'><p>Doctor not found!</p></div>";
        }
        $conn->close();
    }
    ?>
</div>

</body>
</html>
