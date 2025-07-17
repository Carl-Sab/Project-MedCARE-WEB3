<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Job Applications Management</title>
<<<<<<< Updated upstream
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fb;
      margin: 0;
      padding: 0;
    }

    .stats-section {
      padding: 20px;
    }

    .stats-section h2 {
      color: #004d40;
    }

    .filter {
      margin-bottom: 20px;
    }

    .filter input[type="text"] {
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 250px;
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

=======
  <link rel="stylesheet" href="../css/adminJobApply.css" />
  <style>
    .Action {
      padding: 5px 10px;
      margin: 0 2px;
      cursor: pointer;
    }
>>>>>>> Stashed changes
    .status-pending {
      color: orange;
      font-weight: bold;
    }
<<<<<<< Updated upstream

    .status-approved {
      color: green;
      font-weight: bold;
    }

    .status-rejected {
      color: red;
      font-weight: bold;
    }

    .download-link {
      text-decoration: none;
      color: #00796b;
      font-weight: bold;
    }

    .download-link:hover {
      text-decoration: underline;
    }

    .Action {
      padding: 5px 10px;
      background-color: #00796b;
      color: white;
      border: none;
      cursor: pointer;
      margin: 5px;
      border-radius: 5px;
    }

    .Action:hover {
      background-color: #004d40;
=======
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
>>>>>>> Stashed changes
    }
  </style>
</head>
<body>
<?php
<<<<<<< Updated upstream
// Database connection
include "../../includes/header.php";
include "../../includes/connection.php";

// Fetching the job applications that are "Pending"
$sql = "SELECT * FROM job_apply WHERE stats = 'Pending';";
$result = $conn->query($sql);
=======
include "../../includes/security.php";
include "../../includes/header.php";
include "../../includes/connection.php";

$pendingSql = "SELECT * FROM job_apply WHERE stats = 'pending'";
$result = $conn->query($pendingSql);
>>>>>>> Stashed changes
?>
  <div class="stats-section">
    <h2>Job Applications Management</h2>

<<<<<<< Updated upstream
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
                <a class="download-link" href="uploads/<?= urlencode($row['file']) ?>" target="_blank">Download</a>
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
=======
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
>>>>>>> Stashed changes
</body>
</html>

<?php $conn->close(); ?>
