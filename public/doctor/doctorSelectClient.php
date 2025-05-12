<?php
include "../../includes/header.php";
include "../../includes/connection.php";

// Get total client count
$sql_count = "SELECT COUNT(*) AS total_clients FROM users WHERE role = 'client'";
$count_result = $conn->query($sql_count);
$count_data = $count_result->fetch_assoc();

// Fetch all clients
$sql = "SELECT id_user, user_name, email FROM users WHERE role = 'client'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Client Management</title>
  <link rel="stylesheet" href="../css/adminManageUser.css">
</head>
<body>

<br><br>
<h2>Client Management</h2>
<br>
<div class="summary">
  <div>
    <h3>Total Clients</h3>
    <p><?= $count_data['total_clients'] ?></p>
  </div>
</div>

<div class="filter">
  <input type="search" id="searchInput" placeholder="Search clients..."/>
</div>

<?php if ($result->num_rows > 0) { ?>
  <table id="clientTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= $row['id_user'] ?></td>
          <td><?= $row['user_name'] ?></td>
          <td><?= $row['email'] ?></td>
          <td>
            <a href="doctorTestResult.php?id_client=<?= $row['id_user'] ?>" class="upload-btn">Upload Test Result</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } else { ?>
  <div class="no-users">
    <h2>No clients found.</h2>
  </div>
<?php } ?>

<script>
  document.getElementById("searchInput").addEventListener("input", function() {
    var filter = this.value.toLowerCase();
    var rows = document.querySelectorAll("#clientTable tbody tr");

    rows.forEach(function(row) {
      var username = row.cells[1].innerText.toLowerCase();
      row.style.display = username.includes(filter) ? "" : "none";
    });
  });
</script>

<style>
.upload-btn {
  background-color: #26a69a;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  text-decoration: none;
  font-size: 14px;
  transition: background 0.3s ease;
}
.upload-btn:hover {
  background-color: #00796b;
}
</style>

</body>
</html>

<?php $conn->close(); ?>
