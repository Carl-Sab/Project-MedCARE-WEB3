<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Statistics</title>
  <link rel="stylesheet" href="../css/adminPanel.css">
  <style>
    .stats-section {
      padding: 20px;
    }

    #filter {
        border: 0px;
        margin-top: 20px;
        display: inline-block;
        padding: 10px 20px;
        background: linear-gradient(135deg, #00796b, #004d40);
        color: white;
        border-radius: 15px;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        transition: 0.3s ease;
    }
    #filter:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
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

    .total-profit {
      font-size: 24px;
      font-weight: bold;
      color: #00796b;
      text-align: right;
    }
  </style>
</head>
<body>

<?php
include "../../includes/header.php";
echo "<style>.n2{display:flex}</style>";

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

$transactions = [
  ["date" => "2025-04-05", "user" => "Ali", "doctor" => "Dr. Smith", "option" => "Consultation", "amount" => 120, "commission" => 20],
  ["date" => "2025-04-07", "user" => "Zainab", "doctor" => "Dr. Leila", "option" => "Vaccination", "amount" => 250, "commission" => 30],
  ["date" => "2025-04-15", "user" => "Omar", "doctor" => "Dr. Noor", "option" => "Test", "amount" => 90, "commission" => 10],
];

$total = 0;
?>

<div class="stats-section">
  <h2>Monthly Transactions</h2>

  <form class="filter" method="GET">
    <label for="month">Choose Month:</label>
    <input type="month" name="month" id="month" value="<?= $selectedMonth ?>">
    <button type="submit" id="filter">Filter</button>
  </form>

  <table>
    <tr>
      <th>Date time</th>
      <th>User name</th>
      <th>Doctor name</th>
      <th>Option</th>
      <th>Transaction Amount ($)</th>
      <th>Admin Commission ($)</th>
    </tr>
    <?php
    foreach ($transactions as $row) {
      if (strpos($row['date'], $selectedMonth) === 0) {
        echo "<tr>
                <td>{$row['date']}</td>
                <td>{$row['user']}</td>
                <td>{$row['doctor']}</td>
                <td>{$row['option']}</td>
                <td>{$row['amount']}</td>
                <td>{$row['commission']}</td>
              </tr>";
        $total += $row['commission'];
      }
    }
    ?>
  </table>

  <div class="total-profit">Total Profit: $<?= $total ?></div>
</div>

</body>
</html>
