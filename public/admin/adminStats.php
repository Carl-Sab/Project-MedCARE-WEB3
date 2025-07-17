<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Statistics</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fb;
      margin: 0;
      padding: 0;
    }

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
      width: 250px;
    }

    .filter button {
      padding: 10px 20px;
      background-color: #00796b;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .filter button:hover {
      background-color: #004d40;
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

    .total-profit {
      font-size: 18px;
      font-weight: bold;
      color: #00796b;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<?php

include "../../includes/security.php";
include "../../includes/header.php";
include "../../includes/connection.php";

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

$sql = "SELECT 
            p.payment_date, 
            u.user_name AS client_name, 
            u2.user_name AS doctor_name,
            d.speciality AS doctor_speciality,
            p.amount, 
            p.type,
            p.admin_percentage 
        FROM payments p 
        JOIN client c ON p.id_client = c.id_client
        JOIN users u ON c.id_client = u.id_user
        JOIN doctor d ON p.id_doctor = d.id_doctor
        JOIN users u2 ON d.id_doctor = u2.id_user
        WHERE DATE_FORMAT(p.payment_date, '%Y-%m') = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $selectedMonth);
$stmt->execute();
$result = $stmt->get_result();
$totalCommission = 0;
?>

<div class="stats-section">
  <h2>Monthly Transactions</h2>

  <form class="filter" method="GET">
    <label for="month">Choose Month:</label>
    <input type="month" name="month" id="month" value="<?= htmlspecialchars($selectedMonth) ?>">
    <button type="submit" id="filter">Filter</button>
  </form>

  <table>
    <tr>
      <th>Date Time</th>
      <th>Client Name</th>
      <th>Doctor Name</th>
      <th>Doctor Speciality</th>
      <th>Payment Type</th>
      <th>Transaction Amount ($)</th>
      <th>Admin Commission ($)</th>
    </tr>

    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['payment_date']}</td>
                <td>{$row['client_name']}</td>
                <td>{$row['doctor_name']}</td>
                <td>{$row['doctor_speciality']}</td>
                <td>{$row['type']}</td>
                <td>{$row['amount']}</td>
                <td>{$row['admin_percentage']}</td>
              </tr>";
        $totalCommission += $row['admin_percentage'];
    }
    ?>
  </table>

  <div class="total-profit">Total Profit: $<?= number_format($totalCommission, 2) ?></div>
</div>

<?php
$conn->close();
?>

</body>
</html>
