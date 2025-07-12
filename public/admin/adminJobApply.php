<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Applications Management</title>
  <link rel="stylesheet" href="../css/adminJobApply.css">
</head>
<body>

<?php
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
  <h2>Job Applications Management</h2>

  <div class="filter">
    <input type="text" id="searchInput" onkeyup="filterTable('pendingTable')" placeholder="Search pending by title...">
  </div>

  <!-- ✅ Pending Applications Table -->
  <h3>Pending Applications</h3>
  <table id="pendingTable">
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
      <?php while ($row = $pendingResult->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_client'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td>
            <?php if (!empty($row['file'])): ?>
              <a class="download-link" href="../cv_uploads/<?= $row['file']?>">Download</a>
            <?php else: ?>
              No file
            <?php endif; ?>
          </td>
          <td><?= $row['booking_price'] ?></td>
          <td><?= $row['chat_sessions_price'] ?></td>
          <td class="status-<?= strtolower($row['stats']) ?>"><?= ucfirst($row['stats']) ?></td>
          <td>
            <form method="POST" action="ApproveJobApply.php">
              <input type="hidden" name="id" value="<?= $row['id_job_apply'] ?>">
              <button type="submit" class="Action">Approve</button>
            </form>
            <form method="POST" action="DeclineJobApply.php">
              <input type="hidden" name="id" value="<?= $row['id_job_apply'] ?>">
              <button type="submit" class="Action">Decline</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- ✅ Approved Applications Table -->
  <h3 style="margin-top: 40px;">Approved Applications</h3>
  <input type="text" id="searchApprovedInput" onkeyup="filterTable('approvedTable')" placeholder="Search approved by title...">

  <table id="approvedTable" style="margin-top: 10px;">
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
      <?php while ($row = $approvedResult->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_client'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td>
            <?php if (!empty($row['file'])): ?>
              <a class="download-link" href="../cv_uploads/<?= $row['file']?>">Download</a>
            <?php else: ?>
              No file
            <?php endif; ?>
          </td>
          <td><?= $row['booking_price'] ?></td>
          <td><?= $row['chat_sessions_price'] ?></td>
          <td class="status-approved">Approved</td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script>
  function filterTable(tableId) {
    const input = document.getElementById(tableId === 'pendingTable' ? 'searchInput' : 'searchApprovedInput').value.toLowerCase();
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    rows.forEach(row => {
      const title = row.cells[1].textContent.toLowerCase();
      row.style.display = (title.includes(input)) ? "" : "none";
    });
  }
</script>

</body>
</html>

<?php $conn->close(); ?>
