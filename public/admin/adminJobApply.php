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
    <h2>Job Applications Management</h2>

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
        <?php while ($row = $result->fetch_assoc()): ?>
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
              <!-- Approve Job Application Form -->
              <form method="POST" action="ApproveJobApply.php">
                <input type="hidden" name="id" value="<?= $row['id_job_apply'] ?>">
                <button type="submit" class="Action">Approve</button>
              </form>

              <!-- Decline Job Application Form -->
              <form method="POST" action="DeclineJobApply.php">
                <input type="hidden" name="id" value="<?= $row['id_job_apply'] ?>">
                <button type="submit" class="Action">Decline</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script>
    function filterTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("#jobTable tbody tr");
      rows.forEach(row => {
        const title = row.cells[1].textContent.toLowerCase();
        row.style.display = (title.includes(input)) ? "" : "none";
      });
    }
  </script>
</body>
</html>

<?php $conn->close(); ?>
