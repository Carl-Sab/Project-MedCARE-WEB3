<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Blood Donation Management</title>
  <link rel="stylesheet" href="../css/adminPanel.css" />
  <link rel="stylesheet" href="../css/adminBloodDonation.css">
</head>
<body>

<?php
include "../../includes/header.php";
echo "<style>.n3{display:flex}</style>";

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

// Dummy data (replace with real DB results)
$donations = [
  ["donor" => "Ali Saleh", "blood" => "A+", "receiver" => "Sarah Noor", "date" => "2025-04-02"],
  ["donor" => "Maya Khaled", "blood" => "B-", "receiver" => "Kareem Zaki", "date" => "2025-04-15"],
  ["donor" => "Ahmed Sami", "blood" => "O+", "receiver" => "Nada Tarek", "date" => "2025-03-21"],
];
?>

<div class="stats-section">
  <h2>Blood Donation Records</h2>

  <form class="filter" method="GET">
    <label for="month">Choose Month:</label>
    <input type="month" name="month" id="month" value="<?= $selectedMonth ?>" />
    <select name="status" id="status">
      <option value="completed">completed</option>
      <option value="pending">pending</option>
      <option value="canceled">canceled</option>
    </select>
    <button type="submit">Filter</button>
  </form>

  <table>
    <tr>
      <th>Donor Name</th>
      <th>Blood Group</th>
      <th>Receiver Name</th>
      <th>Date of Donation</th>
    </tr>
    <?php
    foreach ($donations as $row) {
      if (strpos($row['date'], $selectedMonth) === 0) {
        echo "<tr>
                <td>{$row['donor']}</td>
                <td>{$row['blood']}</td>
                <td>{$row['receiver']}</td>
                <td>{$row['date']}</td>
              </tr>";
      }
    }
    ?>
  </table>
</div>

</body>
</html>
