<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Doctor Statistics</title>
  <link rel="stylesheet" href="../css/doctorStats.css">
</head>
<body>

<?php
include "../../includes/header.php";
include "../../includes/connection.php";  // Ensure database connection

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

// SQL query to retrieve payment data with doctor profit
$sql = "SELECT 
            p.payment_date, 
            u.user_name AS client_name, 
            u2.user_name AS doctor_name,
            d.speciality AS doctor_speciality,
            p.amount, 
            p.admin_percentage,
            (p.amount - p.admin_percentage) AS doctor_profit
        FROM 
            payments p
        JOIN 
            client c ON p.id_client = c.id_client
        JOIN 
            users u ON c.id_client = u.id_user         -- client user name
        JOIN 
            doctor d ON p.id_doctor = d.id_doctor
        JOIN 
            users u2 ON d.id_doctor = u2.id_user       -- doctor user name
        WHERE 
            DATE_FORMAT(p.payment_date, '%Y-%m') = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $selectedMonth);
$stmt->execute();
$result = $stmt->get_result();

$totalCommission = 0;
$totalDoctorProfit = 0;
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
      <th>Transaction Amount ($)</th>
      <th>Admin Commission ($)</th>
      <th>Doctor Profit ($)</th>
    </tr>

    <?php
    if ($result->num_rows === 0) {
        echo '<tr><td colspan="7">No Doctors found.</td></tr>';
    } else {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['payment_date']}</td>
                    <td>{$row['client_name']}</td>
                    <td>{$row['doctor_name']}</td>
                    <td>{$row['doctor_speciality']}</td>
                    <td>{$row['amount']}</td>
                    <td>{$row['admin_percentage']}</td>
                    <td>" . number_format($row['doctor_profit'], 2) . "</td>
                  </tr>";
            $totalCommission += $row['admin_percentage'];
            $totalDoctorProfit += $row['doctor_profit'];
        }
    }
    $totalDoctorProfit -= $totalCommission;
    ?>
  </table>

  <div class="totals">
    <p><strong>Total Admin Profit:</strong> $<?= number_format($totalCommission, 2) ?></p>
    <p><strong>Total Doctor Profit:</strong> $<?= number_format($totalDoctorProfit, 2) ?></p>
  </div>
</div>

<?php
$conn->close();
?>

</body>
</html>
