<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Client Reports</title>
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

    .status-pending {
      color: orange;
      font-weight: bold;
    }

    .status-readed {
      color: green;
      font-weight: bold;
    }

    .date {
      font-size: 0.9em;
      color: #555;
    }

    .mark-read-btn {
      background-color: #00796b;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .mark-read-btn:hover {
      background-color: #005f56;
    }
  </style>
</head>
<body>

<?php
include "../../includes/header.php";
echo "<style>.n2{display:flex}</style>";

include "../../includes/connection.php";

$sql = "SELECT u.user_name, c.id_client, r.id_report, r.description, r.stats, r.date_of_post 
        FROM users u, client c, report r
        WHERE u.id_user = c.id_client 
          AND c.id_client = r.id_client 
          AND r.stats = 'pending';";

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
