<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Schedule Management</title>
  <link rel="stylesheet" href="../css/adminManageSchedule.css">
</head>
<body>
<?php
  include "../../includes/security.php";
  include "../../includes/header.php";
  include "../../includes/connection.php";

  ?>
  <h2>Doctor Schedule Management</h2>

  <div class="summary">
    <div>
      <h3>Total Doctors</h3>
      <p>5</p>
    </div>
    <div>
      <h3>Total Slots</h3>
      <p>20</p>
    </div>
  </div>

  <div class="filter">
    <input type="search" placeholder="Search Doctor Name...">
  </div>

  <table>
  <thead>
    <tr>
      <th>Doctor Name</th>
      <th>Time Slot</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody id="schedule-table">
    <?php
    include "../../includes/connection.php";

    // Fetch all doctors
    $query = "SELECT * FROM users WHERE role = 'doctor'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $doctorName = "Dr. " . htmlspecialchars($row['user_name']);
        $doctorId = $row['id_user'];

        // Check for schedule for the doctor
        $scheduleQuery = "SELECT * FROM time_slots WHERE id_doctor = $doctorId";
        $scheduleResult = mysqli_query($conn, $scheduleQuery);

        if ($scheduleResult && mysqli_num_rows($scheduleResult) > 0) {
          while ($scheduleRow = mysqli_fetch_assoc($scheduleResult)) {
            $date = $scheduleRow['date'] ?? "—";
            $startTime = $scheduleRow['start_time'];
            $endTime = $scheduleRow['End_time'];
            $status = $scheduleRow['is_booked'] ? "Booked" : "Available";
            
            echo "<tr>
                    <td>$doctorName</td>
                    <td>$startTime - $endTime</td>
                    <td>$status</td>
                    <td class='action-buttons'>
                      <button class='delete-btn'>Delete</button>
                    </td>
                  </tr>";
          }
        } else {
          // If no schedule exists, show "No Schedule"
          echo "<tr>
                  <td>$doctorName</td>
                  <td>No Schedule</td>
                  <td>Unavailable</td>
                  <td class='action-buttons'>
 
                    <button class='delete-btn'>Delete</button>
                  </td>
                </tr>";
        }
      }
    } else {
      echo "<tr><td colspan='5'>No doctors found.</td></tr>";
    }
    ?>
  </tbody>
</table>

  <button id='edit-btn'><a href="adminChooseSchedule">Change Schedule</a></button>

  <script>
  
    document.getElementById('schedule-table').addEventListener('click', (event) => {
      // Edit functionality
      if (event.target.classList.contains('edit-btn')) {
        const row = event.target.closest('tr');
        const cells = row.getElementsByTagName('td');
        const doctorName = prompt('Edit Doctor Name:', cells[0].innerText);
        const date = prompt('Edit Date (YYYY-MM-DD):', cells[1].innerText);
        const timeSlot = prompt('Edit Time Slot (e.g., 1:00 PM - 2:00 PM):', cells[2].innerText);
        const status = prompt('Edit Status (Available/Booked):', cells[3].innerText);

        if (doctorName && date && timeSlot && status) {
          cells[0].innerText = doctorName;
          cells[1].innerText = date;
          cells[2].innerText = timeSlot;
          cells[3].innerText = status;
          alert('Slot updated successfully!');
        }
      }

      // Delete functionality
      if (event.target.classList.contains('delete-btn')) {
        const row = event.target.closest('tr');
        row.remove();
        alert('Slot deleted successfully!');
      }
    });
  </script>
</body>
</html>