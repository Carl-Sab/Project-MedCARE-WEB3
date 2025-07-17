<?php
include "../../includes/security.php";
include "../../includes/connection.php";

$id_client = $_SESSION['id_user'];  // get logged-in client ID
?>
<!DOCTYPE html>
<html lang="en">
<head>
<<<<<<< Updated upstream
  <meta charset="UTF-8">
  <title>Admin - Test Results</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f0f4f9;
    }

    header {
      background: linear-gradient(90deg, #00796b, #004d40);
      color: white;
      padding: 20px;
      text-align: center;
    }

    .stats-section {
      padding: 20px;
    }

    .stats-section h2 {
      color: #004d40;
    }

    .search-bar {
      margin-bottom: 20px;
    }

    .search-bar input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .filter {
      margin-bottom: 20px;
    }

    .filter select {
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    table th, table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }

    table th {
      background-color: #00796b;
      color: white;
    }

    .status-pending {
      color: orange;
      font-weight: bold;
    }

    .status-completed {
      color: green;
      font-weight: bold;
    }

    .date {
      font-size: 0.9em;
      color: #555;
    }

    .action-btn {
      background-color: #00796b;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .action-btn:hover {
      background-color: #005f56;
    }

    .pagination {
      margin-top: 20px;
      text-align: center;
    }

    .pagination button {
      padding: 10px;
      margin: 5px;
      border: none;
      background-color: #00796b;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    .pagination button:hover {
      background-color: #005f56;
    }

    .notifications {
      margin-bottom: 20px;
      padding: 10px;
      background-color: #e0f2f1;
      border-left: 4px solid #004d40;
      font-size: 0.9em;
    }

    .notifications p {
      margin: 0;
    }

    @media (max-width: 768px) {
      table th, table td {
        font-size: 0.9em;
      }

      .action-btn {
        font-size: 0.8em;
        padding: 5px 10px;
      }
    }
  </style>
=======
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Test Results</title>
  <link rel="stylesheet" href="../css/adminTestResult.css">
>>>>>>> Stashed changes
</head>
<body>
  <?php include "../../includes/header.php"; ?>

  <h2>My Test Results</h2>

  <table>
    <thead>
      <tr>
        <th>Doctor Name</th>
        <th>Test Name</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="results-table">
      <?php
      $sql = "SELECT 
                tr.id_result, 
                u_doctor.user_name AS doctor_name,
                tr.result, 
                tr.date_result,
                tr.fileName
              FROM test_result tr
              LEFT JOIN users u_doctor ON tr.id_doctor = u_doctor.id_user
              WHERE tr.id_client = ?
              ORDER BY tr.date_result DESC";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id_client);
      $stmt->execute();
      $res = $stmt->get_result();

      if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
          $status = stripos($row['result'], 'pending') !== false ? 'Pending' : 'Completed';
          echo "<tr>
                  <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                  <td>" . htmlspecialchars($row['result']) . "</td>
                  <td>" . htmlspecialchars($row['date_result']) . "</td>
                  <td class='action-buttons'>
                    <a class='view-btn' href='../test_result_uploads/" . htmlspecialchars($row['fileName']) . "' target='_blank' rel='noopener noreferrer'>View</a>
                  </td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No test results found.</td></tr>";
      }

      $stmt->close();
      $conn->close();
      ?>
    </tbody>
  </table>
</body>
</html>
