<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Emergency Requests</title>
  <link rel="stylesheet" href="../css/adminEmergency.css">
</head>
<body>

<?php
include "../../includes/security.php";
include "../../includes/header.php";
include "../../includes/connection.php";

$sql = "SELECT u.user_name, c.id_client, e.id_emergency, e.reason, e.date_emergency, e.stats 
        FROM users u, client c, emergency e
        WHERE u.id_user = c.id_client AND c.id_client = e.id_client AND e.stats = 'Pending' 
        ORDER BY e.date_emergency ASC;";


$result = $conn->query($sql);
?>

<div class="stats-section">
  <h2>Emergency Request Records</h2>
  <br>

  <?php if ($result->num_rows > 0) { ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Client</th>
          <th>Condition</th>
          <th>Status</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?= $row['id_client'] ?></td>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><?= htmlspecialchars($row['reason']) ?></td>
            <td class="status-<?= strtolower($row['stats']) ?>">
              <?= ucfirst($row['stats']) ?>
            </td>
            <td class="date"><?= $row['date_emergency'] ?></td>
            <td>
              <form method="POST" action="markReadReq.php">
                <input type="hidden" name="id_emergency" value="<?= $row['id_emergency'] ?>">
                <button type="submit" class="mark-read-btn">Mark as Read</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <h2>No emergency requests found.</h2>
  <?php } ?>

</div>

</body>
</html>

<?php $conn->close(); ?>
