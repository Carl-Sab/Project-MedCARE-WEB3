<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Blood Requests</title>
  <link rel="stylesheet" href="../css/adminPanel.css" />
  <link rel="stylesheet" href="../css/adminBloodDonation.css">
</head>
<body>

<?php
<<<<<<< Updated upstream
=======
include "../../includes/security.php";
>>>>>>> Stashed changes
include "../../includes/header.php";
include "../../includes/connection.php";

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

<<<<<<< Updated upstream
$sql = "SELECT r.id_blood_req, u.user_name AS requester, r.blood_type, r.date_request, r.status, t.id_transaction, t.id_donor, t.date_transaction
=======
$sql = "SELECT r.id_blood_req, u.user_name AS requester, r.blood_type, r.date_request, r.status
>>>>>>> Stashed changes
        FROM blood_request r
        JOIN users u ON r.id_requester = u.id_user
        LEFT JOIN blood_transaction t ON r.id_blood_req = t.id_blood_req
        WHERE DATE_FORMAT(r.date_request, '%Y-%m') = ?;";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $selectedMonth);
$stmt->execute();
$result = $stmt->get_result();
<<<<<<< Updated upstream
=======

$sqlApproved = "SELECT r.id_blood_req, u.user_name AS requester, r.blood_type, r.date_request,
                       t.id_transaction, t.id_donor, t.date_transaction
                FROM blood_request r
                JOIN users u ON r.id_requester = u.id_user
                JOIN blood_transaction t ON r.id_blood_req = t.id_blood_req
                WHERE DATE_FORMAT(r.date_request, '%Y-%m') = ? AND r.status = 'approved'";
$stmtApproved = $conn->prepare($sqlApproved);
$stmtApproved->bind_param("s", $selectedMonth);
$stmtApproved->execute();
$resultApproved = $stmtApproved->get_result();
>>>>>>> Stashed changes
?>

<div class="stats-section">
  <h2>Blood Request & Transaction Records</h2>

  <form class="filter" method="GET">
    <label for="month">Choose Month:</label>
    <input type="month" name="month" id="month" value="<?= htmlspecialchars($selectedMonth) ?>" />
    <button type="submit">Filter</button>
  </form>

  <table>
    <tr>
      <th>Request ID</th>
      <th>Requester Name</th>
      <th>Blood Type</th>
      <th>Date of Request</th>
      <th>Status</th>
      <th>Transaction ID</th>
      <th>Donor ID</th>
      <th>Date of Transaction</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['id_blood_req']) ?></td>
        <td><?= htmlspecialchars($row['requester']) ?></td>
        <td><?= htmlspecialchars($row['blood_type']) ?></td>
        <td><?= htmlspecialchars($row['date_request']) ?></td>
<<<<<<< Updated upstream
        <td class="<?= $row['status'] == 'pending' ? 'pending-status' : '' ?>">
          <?= htmlspecialchars($row['status']) ?>
        </td>
        <td><?= $row['id_transaction'] ? htmlspecialchars($row['id_transaction']) : 'N/A' ?></td>
        <td><?= $row['id_donor'] ? htmlspecialchars($row['id_donor']) : 'N/A' ?></td>
        <td><?= $row['date_transaction'] ? htmlspecialchars($row['date_transaction']) : 'N/A' ?></td>
=======
        <td class="pending-status"><?= htmlspecialchars($row['status']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<div class="stats-section">
  <h2>Approved Blood Requests</h2>

  <table>
    <tr>
      <th>Request ID</th>
      <th>Requester Name</th>
      <th>Blood Type</th>
      <th>Date of Request</th>
      <th>Transaction ID</th>
      <th>Donor ID</th>
      <th>Date of Transaction</th>
    </tr>
    <?php while ($row = $resultApproved->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['id_blood_req']) ?></td>
        <td><?= htmlspecialchars($row['requester']) ?></td>
        <td><?= htmlspecialchars($row['blood_type']) ?></td>
        <td><?= htmlspecialchars($row['date_request']) ?></td>
        <td><?= htmlspecialchars($row['id_transaction']) ?></td>
        <td><?= htmlspecialchars($row['id_donor']) ?></td>
        <td><?= htmlspecialchars($row['date_transaction']) ?></td>
>>>>>>> Stashed changes
      </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>
