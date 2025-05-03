<?php
include "../../includes/connection.php";

$sql = "SELECT cr.feedback, cr.rating, cr.submitted_at, u.user_name AS client_name, d.user_name AS doctor_name, cs.ended_at
        FROM review cr 
        JOIN chat_sessions cs ON cr.chat_session_id = cs.chat_session_id 
        JOIN users u ON cr.id_user = u.id_user 
        JOIN users d ON cs.id_doctor = d.id_user
        ORDER BY cr.submitted_at DESC";

$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Chat Reviews (Admin Panel)</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f7fb;
      padding: 20px;
    }
    h2 {
      color: #004d40;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: center;
    }
    th {
      background-color: #00796b;
      color: white;
    }
  </style>
</head>
<body>

<h2>All Chat Reviews</h2>

<table>
  <tr>
    <th>Client Name</th>
    <th>Doctor Name</th>
    <th>Rating</th>
    <th>Feedback</th>
    <th>Chat End Time</th>
    <th>Submitted At</th>
  </tr>

  <?php
  while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['client_name']) ?></td>
      <td><?= htmlspecialchars($row['doctor_name']) ?></td>
      <td><?= $row['rating'] ?> / 5</td>
      <td><?= htmlspecialchars($row['feedback']) ?></td>
      <td><?= htmlspecialchars($row['ended_at']) ?></td> <!-- Corrected from end_time to ended_at -->
      <td><?= htmlspecialchars($row['submitted_at']) ?></td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
