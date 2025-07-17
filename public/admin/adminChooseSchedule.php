<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Schedule</title>
  <link rel="stylesheet" href="../css/adminChooseSchedule.css">
</head>
<body>

<?php
include "../../includes/security.php";
include "../../includes/header.php";
include "../../includes/connection.php";
?>

<div class="schedule-container">
  <h2>Doctor's Weekly Schedule</h2>

  <form method="POST" action="">
    <label for="doctor">Choose a doctor:</label>
    <select id="doctor" name="doctor_id" required>
      <?php
      $query = "SELECT id_user, user_name FROM users WHERE role = 'doctor'";
      $result = mysqli_query($conn, $query);
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<option value="' . htmlspecialchars($row['id_user']) . '">Dr. ' . htmlspecialchars($row['user_name']) . '</option>';
        }
      } else {
        echo '<option disabled>No doctors found</option>';
      }
      ?>
    </select>

    <label>Start hour (08-20):</label>
    <select name="start_time" required>
      <?php
      for ($h = 8; $h <= 20; $h++) {
        printf('<option value="%02d:00">%02d:00</option>', $h, $h);
      }
      ?>
    </select>

    <label>End hour (08-20):</label>
    <select name="end_time" required>
      <?php
      for ($h = 8; $h <= 20; $h++) {
        printf('<option value="%02d:00">%02d:00</option>', $h, $h);
      }
      ?>
    </select>

    <button type="submit">Save Schedule</button>
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $doctorId = intval($_POST['doctor_id']);
    $start_time = $_POST['start_time']; // format "HH:00"
    $end_time = $_POST['end_time'];

    if (!empty($start_time) && !empty($end_time)) {
      if ($start_time < $end_time) {
        $stmt = $conn->prepare("INSERT INTO time_slots (id_doctor, start_time, end_time) VALUES (?, ?, ?)");
        if ($stmt) {
          $stmt->bind_param("iss", $doctorId, $start_time, $end_time);
          if ($stmt->execute()) {
            echo "<div class='result'><p>Schedule saved successfully!</p></div>";
          } else {
            echo "<div class='result'><p>Error saving schedule: " . htmlspecialchars($stmt->error) . "</p></div>";
          }
          $stmt->close();
        } else {
          echo "<div class='result'><p>Failed to prepare SQL statement.</p></div>";
        }
      } else {
        echo "<div class='result'><p>Start time must be before end time.</p></div>";
      }
    } else {
      echo "<div class='result'><p>Please select both start and end time.</p></div>";
    }
    $conn->close();
  }
  ?>
</div>

</body>
</html>
