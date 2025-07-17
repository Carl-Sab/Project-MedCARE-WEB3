<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Client Reports</title>
  <link rel="stylesheet" href="../css/adminReport.css">
</head>
<body>

<?php
<<<<<<< Updated upstream
include "../../includes/header.php";


=======
include "../../includes/security.php";
include "../../includes/header.php";
>>>>>>> Stashed changes
include "../../includes/connection.php";

$sql = "SELECT u.user_name, c.id_client, r.id_report, r.description, r.stats, r.date_of_post FROM users u, client c, report r
        WHERE u.id_user = c.id_client AND c.id_client = r.id_client AND r.stats = 'pending';";

$result = $conn->query($sql);
?>

<div class="stats-section">
  <h2>Client Reports</h2>
  <br>
 
      <?php if ($result->num_rows > 0){
        ?>
          <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Description</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $result->fetch_assoc()){ ?>
          <tr>
            <td><?= $row['id_client'] ?></td>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td class="status-<?= strtolower($row['stats']) ?>">
              <?= ucfirst($row['stats']) ?>
            </td>
            <td class="date"><?= $row['date_of_post'] ?></td>
            <td>
              <form method="POST" action="markRead.php">
                <input type="hidden" name="id_report" value="<?= $row['id_report'] ?>">
                <button type="submit" class="mark-read-btn">Mark as Read</button>
              </form>
            </td>
          </tr>
        <?php }?>
        </tbody>
        </table>
        <?php
      }
        else{
       ?>
        <h2>No reports found.</h2>
      <?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php $conn->close(); ?>
