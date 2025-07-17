<?php
include "../../includes/security.php";
include "../../includes/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Test Results Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fb;
      margin: 0;
      padding: 0;
    }
    h2 {
      color: #004d40;
      margin: 20px;
    }
    .filter {
      margin: 20px;
    }
    .filter input {
      padding: 12px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      width: 250px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px;
    }
    table th, table td {
      padding: 15px;
      text-align: center;
      border: 1px solid #ddd;
    }
    table th {
      background-color: #00796b;
      color: white;
    }
    .action-buttons a {
      background-color: #00796b;
      color: white;
      padding: 6px 10px;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }
    .action-buttons a:hover {
      background-color: #005f56;
    }
  </style>
</head>
<body>

  <?php include "../../includes/header.php"; ?>
  <h2>Test Results Management</h2>

  <div class="filter">
    <input type="search" id="searchInput" placeholder="Search by Patient or Test Name...">
  </div>

  <table>
    <thead>
      <tr>
        <th>Patient Name</th>
        <th>Doctor Name</th>
        <th>Test Result</th>
        <th>Date</th>
        <th>Status</th>
        <th>File</th>
      </tr>
    </thead>
    <tbody id="results-table">
      <?php
      $sql = "SELECT 
                tr.id_result, 
                tr.result,
                tr.date_result,
                tr.fileName,
                u_client.user_name AS patient_name,
                u_doctor.user_name AS doctor_name
              FROM test_result tr
              LEFT JOIN users u_client ON tr.id_client = u_client.id_user
              LEFT JOIN users u_doctor ON tr.id_doctor = u_doctor.id_user
              ORDER BY tr.date_result DESC";

      $res = $conn->query($sql);

      if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
          $status = stripos($row['result'], 'pending') !== false ? 'Pending' : 'Completed';
          $filename = htmlspecialchars($row['fileName']);

          echo "<tr>
                  <td>" . htmlspecialchars($row['patient_name']) . "</td>
                  <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                  <td>" . htmlspecialchars($row['result']) . "</td>
                  <td>" . htmlspecialchars($row['date_result']) . "</td>
                  <td>$status</td>
                  <td class='action-buttons'>
                    <a href='../test_result_uploads/{$filename}' target='_blank'>View</a>
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
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#results-table tr');

    searchInput.addEventListener('input', function() {
      const term = this.value.toLowerCase();
      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const text = Array.from(cells).map(td => td.textContent.toLowerCase()).join(' ');
        row.style.display = text.includes(term) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
