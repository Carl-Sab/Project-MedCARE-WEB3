<?php
include "../../includes/connection.php";
include "../../includes/security.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Test Results Management</title>
  <link rel="stylesheet" href="../css/adminTestResult.css">
</head>
<body>
   <?php include "../../includes/header.php";

  ?>
  <h2>Test Results Management</h2>

  <div class="filter">
    <input type="search" placeholder="Search by Patient or Test Name...">
  </div>

  <table>
    <thead>
      <tr>
        <th>Patient Name</th>
        <th>Doctor Name</th>
        <th>Test Name</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="results-table">
      <?php
      $sql = "SELECT 
                tr.id_result, 
                u_client.user_name AS patient_name,
                u_doctor.user_name AS doctor_name,
                tr.result, 
                tr.date_result,
                tr.fileName
              FROM test_result tr
              LEFT JOIN users u_client ON tr.id_client = u_client.id_user
              LEFT JOIN users u_doctor ON tr.id_doctor = u_doctor.id_user
              ORDER BY tr.date_result DESC";

      $res = $conn->query($sql);
      if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
          $status = stripos($row['result'], 'pending') !== false ? 'Pending' : 'Completed';
          echo "<tr>
                  <td>{$row['patient_name']}</td>
                  <td>{$row['doctor_name']}</td>
                  <td>{$row['result']}</td>
                  <td>{$row['date_result']}</td>
                  <td>$status</td>
                  <td class='action-buttons'>
                    <a class='view-btn' href='../test_result_uploads/{$row['fileName']}'>View</a>
                  </td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='6'>No test results found.</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <script>
    document.getElementById('add-result-btn').addEventListener('click', () => {
      alert('Redirect to add result form (to be implemented).');
    });

    document.getElementById('results-table').addEventListener('click', (event) => {
      if (event.target.classList.contains('view-btn')) {
        const id = event.target.getAttribute('data-id');
        alert('Viewing test result ID: ' + id);
      }

      if (event.target.classList.contains('edit-btn')) {
        const id = event.target.getAttribute('data-id');
        alert('Redirect to edit result form for ID: ' + id);
      }
    });
  </script>
</body>
</html>
