<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Emergency Request Management</title>
  <link rel="stylesheet" href="../css/adminPanel.css" />
  <style>
    .stats-section {
      padding: 20px;
    }

    .stats-section h2 {
      color: #004d40;
    }

    .filter {
      margin-bottom: 20px;
    }

    .filter input[type="month"] {
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
  </style>
</head>
<body>

<?php
include "../../includes/header.php";
echo "<style>.n2{display:flex}</style>";

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

// Dummy data (replace with real DB results)
$emergencyRequests = [
  ["patient" => "Ziad Fathi", "condition" => "High Fever", "doctor" => "Dr. Omar", "date" => "2025-04-03"],
  ["patient" => "Layla Ahmed", "condition" => "Breathing Difficulty", "doctor" => "Dr. Sara", "date" => "2025-04-14"],
  ["patient" => "Hassan Tarek", "condition" => "Severe Headache", "doctor" => "Dr. Khaled", "date" => "2025-03-20"],
];
?>

<div class="stats-section">
  <h2>Emergency Request Records</h2>

  <form class="filter" method="GET">
    <label for="month">Choose Month:</label>
    <input type="month" name="month" id="month" value="<?= $selectedMonth ?>" />
    <button type="submit">Filter</button>
  </form>

  <table>
    <tr>
      <th>Patient Name</th>
      <th>Condition</th>
      <th>Assigned Doctor</th>
      <th>Date of Request</th>
    </tr>
    <?php
    foreach ($emergencyRequests as $row) {
      if (strpos($row['date'], $selectedMonth) === 0) {
        echo "<tr>
                <td>{$row['patient']}</td>
                <td>{$row['condition']}</td>
                <td>{$row['doctor']}</td>
                <td>{$row['date']}</td>
              </tr>";
      }
    }
    ?>
  </table>
</div>

</body>
</html>
  