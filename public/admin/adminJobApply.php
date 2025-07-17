<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Job Applications Management</title>
  <link rel="stylesheet" href="../css/adminJobApply.css" />
  <style>
    .Action {
      padding: 5px 10px;
      margin: 0 2px;
      cursor: pointer;
    }
    .status-pending {
      color: orange;
      font-weight: bold;
    }

    .download-link {
      color: blue;
      text-decoration: underline;
    }
    .filter-input {
      margin-bottom: 10px;
      padding: 6px;
      width: 300px;
      font-size: 14px;
    }
    .no-data {
      font-style: italic;
      color: #666;
      padding: 10px 0;
    }
  </style>
</head>
<body>
<?php

include "../../includes/security.php";
include "../../includes/header.php";
include "../../includes/connection.php";

$pendingSql = "SELECT * FROM job_apply WHERE stats = 'pending'";
$result = $conn->query($pendingSql);
?>
<div class="stats-section">
  <h2>Job Applications Management</h2><br>

  <h3>Pending Applications</h3>
  <br>

  <?php if ($result->num_rows > 0): ?>
  <table id="pendingTable" border="1" cellspacing="0" cellpadding="6" width="100%">
    <thead>
      <tr>
        <th>Client ID</th>
        <th>Speciality</th>
        <th>Description</th>
        <th>File</th>
        <th>Booking Price</th>
        <th>Chat Price</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id_client']) ?></td>
          <td><?= htmlspecialchars($row['speciality']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td>
            <?php if (!empty($row['file'])): ?>
              <a class="download-link" href="../cv_uploads/<?= htmlspecialchars($row['file']) ?>" target="_blank" rel="noopener noreferrer">Download</a>
            <?php else: ?>
              No file
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['booking_price']) ?></td>
          <td><?= htmlspecialchars($row['chat_sessions_price']) ?></td>
          <td class="status-pending"><?= ucfirst(htmlspecialchars($row['stats'])) ?></td>
          <td>
            <form method="POST" action="ApproveJobApply.php" style="display:inline;">
              <input type="hidden" name="id" value="<?= htmlspecialchars($row['id_job_apply']) ?>" />
              <button type="submit" class="Action">Approve</button>
            </form>
            <form method="POST" action="DeclineJobApply.php" style="display:inline;">
              <input type="hidden" name="id" value="<?= htmlspecialchars($row['id_job_apply']) ?>" />
              <button type="submit" class="Action">Decline</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p class="no-data">No job applications found.</p>
  <?php endif; ?>
</div>
</body>
</html>

<?php $conn->close(); ?>
