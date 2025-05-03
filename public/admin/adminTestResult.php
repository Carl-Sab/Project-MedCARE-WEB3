<?php
include "../../includes/connection.php"; // Adjust this path as needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Test Results Management</title>
  <style>
    /* General Styling */
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
    .summary {
      display: flex;
      justify-content: space-between;
      margin: 20px;
    }
    .summary div {
      background-color: #00796b;
      color: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      flex: 1;
      margin: 0 10px;
      transition: background-color 0.3s ease;
    }
    .summary div:hover {
      background-color: #004d40;
    }
    .filter {
      display: flex;
      justify-content: flex-start;
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
    .action-buttons button {
      background-color: #00796b;
      color: white;
      padding: 8px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease-in-out;
    }
    .action-buttons button:hover {
      background-color: #005f56;
      transform: scale(1.1);
    }
    #add-result-btn {
      margin: 20px;
      padding: 10px;
      background-color: #00796b;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    #add-result-btn:hover {
      background-color: #005f56;
    }
  </style>
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
                tr.date_result
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
                    <button class='view-btn' data-id='{$row['id_result']}'>View</button>
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
