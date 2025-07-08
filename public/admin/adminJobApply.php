<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Applications Management</title>
  <link rel="stylesheet" href="../css/adminJobApply.css">
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../../includes/header.php";
include "../../includes/connection.php";

// ✅ Check connection
if (!$conn) {
  die("<p style='color:red;'>Connection failed: " . mysqli_connect_error() . "</p>");
}

// ✅ Query: Pending Applications
$pendingSql = "SELECT * FROM job_apply WHERE stats = 'pending'";
$pendingResult = $conn->query($pendingSql);
?>

<div class="stats-section">
  <h2>Pending Job Applications</h2>

  <div class="filter">
    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search by title or description...">
  </div>

  <table id="jobTable">
    <thead>
      <tr>
        <th>Client ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>File</th>
        <th>Booking Price</th>
        <th>Chat Price</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($pendingResult && $pendingResult->num_rows > 0):
        while ($row = $pendingResult->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id_client'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td>
            <?php if (!empty($row['file'])): ?>
              <a class="download-link" href="../cv_uploads/<?= htmlspecialchars($row['file']) ?>">Download</a>
            <?php else: ?>
              No file
            <?php endif; ?>
          </td>
          <td><?= $row['booking_price'] ?></td>
          <td><?= $row['chat_sessions_price'] ?></td>
          <td class="status-<?= $row['stats'] ?>"><?= ucfirst($row['stats']) ?></td>
          <td>
            <form method="POST" action="ApproveJobApply.php" style="display:inline;">
              <input type="hidden" name="id" value="<?= $row['id_job_apply'] ?>">
              <button type="submit" class="Action">Approve</button>
            </form>
            <form method="POST" action="DeclineJobApply.php" style="display:inline;">
              <input type="hidden" name="id" value="<?= $row['id_job_apply'] ?>">
              <button type="submit" class="Action">Decline</button>
            </form>
          </td>
        </tr>
      <?php
        endwhile;
      else:
        echo "<tr><td colspan='8' style='text-align:center;'>No pending applications found.</td></tr>";
      endif;
      ?>
    </tbody>
  </table>
</div>

<!-- Optional: Show Approved Applications Below -->
<?php
$approvedSql = "SELECT * FROM job_apply WHERE stats = 'approved'";
$approvedResult = $conn->query($approvedSql);
?>

<div class="stats-section">
  <h2>Approved Applications</h2>
  <table>
    <thead>
      <tr>
        <th>Client ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>File</th>
        <th>Booking Price</th>
        <th>Chat Price</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($approvedResult && $approvedResult->num_rows > 0):
        while ($row = $approvedResult->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id_client'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td>
            <?php if (!empty($row['file'])): ?>
              <a class="download-link" href="../cv_uploads/<?= htmlspecialchars($row['file']) ?>">Download</a>
            <?php else: ?>
              No file
            <?php endif; ?>
          </td>
          <td><?= $row['booking_price'] ?></td>
          <td><?= $row['chat_sessions_price'] ?></td>
          <td class="status-approved">Approved</td>
        </tr>
      <?php
        endwhile;
      else:
        echo "<tr><td colspan='7' style='text-align:center;'>No approved applications.</td></tr>";
      endif;
      ?>
    </tbody>
  </table>
</div>
<?php
$rejectedSql = "SELECT * FROM job_apply WHERE stats = 'rejected'";
$rejectedResult = $conn->query($rejectedSql);
?>
<div class="stats-section">
  <h2>Rejected Applications</h2>
  <table>
    <thead>
      <tr>
        <th>Client ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>File</th>
        <th>Booking Price</th>
        <th>Chat Price</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($rejectedResult && $rejectedResult->num_rows > 0):
        while ($row = $rejectedResult->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id_client'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td>
            <?php if (!empty($row['file'])): ?>
              <a class="download-link" href="../cv_uploads/<?= htmlspecialchars($row['file']) ?>">Download</a>
            <?php else: ?>
              No file
            <?php endif; ?>
          </td>
          <td><?= $row['booking_price'] ?></td>
          <td><?= $row['chat_sessions_price'] ?></td>
          <td class="status-approved">Rejected</td>
        </tr>
      <?php
        endwhile;
      else:
        echo "<tr><td colspan='7' style='text-align:center;'>No approved applications.</td></tr>";
      endif;
      ?>
    </tbody>
  </table>
</div>
<script>
function filterTable() {
  const input = document.getElementById("searchInput").value.toLowerCase();
  const rows = document.querySelectorAll("#jobTable tbody tr");
  rows.forEach(row => {
    const title = row.cells[1].textContent.toLowerCase();
    const desc = row.cells[2].textContent.toLowerCase();
    const show = title.includes(input) || desc.includes(input);
    row.style.display = show ? "" : "none";
  });
}
</script>

</body>
</html>

<?php $conn->close(); ?>
