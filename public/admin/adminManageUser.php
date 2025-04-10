<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - User Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fb;
      margin: 0;
      padding: 0;
    }
    h2 {
      color: #004d40;
      margin-bottom: 20px;
    }

    .filter {
      margin-bottom: 20px;
      display: flex;
      justify-content: flex-start;
    }

    .filter input[type="search"] {
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 250px;
      margin-left: 10px;
    }

    .summary {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    .summary div {
      background-color: #00796b;
      color: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      flex: 1;
      margin: 0 10px;
      transition: background-color 0.3s ease;
    }

    .summary div h3 {
      margin: 0;
      font-size: 18px;
    }

    .summary div p {
      font-size: 32px;
      margin: 10px 0;
      font-weight: bold;
    }

    .summary div:hover {
      background-color: #004d40;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table th, table td {
      padding: 15px;
      text-align: center;
      border: 1px solid #ddd;
      font-size: 14px;
    }

    table th {
      background-color: #00796b;
      color: white;
    }

    .role-btn {
      background-color: #00796b;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .role-btn:hover {
      background-color: #005f56;
    }

    .status {
      font-weight: bold;
      text-transform: capitalize;
    }

    .role {
      color: #00796b;
    }

    .role select {
      padding: 6px;
      border-radius: 5px;
      font-size: 14px;
    }

    .no-users {
      text-align: center;
      font-size: 18px;
      color: #555;
    }
  </style>
</head>
<body>

<?php
include "../../includes/header.php";
echo "<style>.n2{display:flex}</style>";

include "../../includes/connection.php";

$sql_count = "SELECT SUM(role = 'client') AS total_clients,SUM(role = 'doctor') AS total_doctors,SUM(role = 'admin') AS total_admins FROM users";
$count_result = $conn->query($sql_count);
$count_data = $count_result->fetch_assoc();

$sql = "SELECT u.id_user, u.user_name, u.email, u.role, c.id_client FROM users u
        LEFT JOIN client c ON u.id_user = c.id_client;";
$result = $conn->query($sql);
?>
<br><br>
  <h2>User Management</h2>
  <br>
  <div class="summary">
    <div>
      <h3>Clients</h3>
      <p><?= $count_data['total_clients'] ?></p>
    </div>
    <div>
      <h3>Doctors</h3>
      <p><?= $count_data['total_doctors'] ?></p>
    </div>
    <div>
      <h3>Admins</h3>
      <p><?= $count_data['total_admins'] ?></p>
    </div>
  </div>

  <div class="filter">
    <input type="search" id="searchInput" placeholder="Search users..."/>
  </div>

  <?php if ($result->num_rows > 0) { ?>
    <table id="userTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?= $row['id_user'] ?></td>
            <td><?= $row['user_name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td class="role"><?= $row['role'] ?></td>
            <td>
              <form method="POST" action="adminUpdateRole.php">
                <input type="hidden" name="id_user" value="<?= $row['id_user'] ?>">
                <select name="role" class="role-btn">
                  <option value="admin" <?= $row['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                  <option value="doctor" <?= $row['role'] == 'doctor' ? 'selected' : '' ?>>Doctor</option>
                  <option value="client" <?= $row['role'] == 'client' ? 'selected' : '' ?>>Client</option>
                </select>
                <button type="submit" class="role-btn">Update Role</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <div class="no-users">
      <h2>No users found.</h2>
    </div>
  <?php } ?>

  <script>
 document.getElementById("searchInput").addEventListener("input", function() {
    var input = document.getElementById("searchInput");
    var filter = input.value.toLowerCase();
    var table = document.getElementById("userTable");
    var rows = table.getElementsByTagName("tr");

    for (var i = 1; i < rows.length; i++) {
      var cells = rows[i].getElementsByTagName("td");
      var found = false;

      var usernameCell = cells[1];

      if (usernameCell && usernameCell.innerText.toLowerCase().indexOf(filter) > -1) {
        found = true;
      }

      if (found) {
        rows[i].style.display = "";
      } else {
        rows[i].style.display = "none";
      }
    }
  });
  </script>

</body>
</html>

<?php $conn->close(); ?>
