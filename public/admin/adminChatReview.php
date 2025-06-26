<?php
include "../../includes/connection.php";

session_start();

$monthFilter = isset($_GET['month']) ? mysqli_real_escape_string($conn, $_GET['month']) : null;

$sql = "SELECT cr.feedback, cr.rating, cr.submitted_at, u.user_name AS client_name, d.user_name AS doctor_name, cs.ended_at
        FROM review cr 
        JOIN chat_sessions cs ON cr.chat_session_id = cs.chat_session_id 
        JOIN users u ON cr.id_user = u.id_user 
        JOIN users d ON cs.id_doctor = d.id_user";

if ($monthFilter) {
    $sql .= " WHERE DATE_FORMAT(cr.submitted_at, '%Y-%m') = '$monthFilter'";
}

$sql .= " ORDER BY cr.submitted_at DESC";

$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Chat Reviews (Admin Panel)</title>
  <link rel="stylesheet" href="../css/adminChatReview.css">
</head>
<body>

<?php include "../../includes/header.php"; ?>

<h2>All Chat Reviews</h2>
<br>
  <form class="filter" method="GET">
    <label for="month">Choose Month:</label>
  <input type="month" name="month" id="month" value="<?= htmlspecialchars($monthFilter ?? '') ?>" />
    <button type="submit" id="filter">Filter</button>
  </form>


<table>
  <tr>
    <th>Client Name</th>
    <th>Doctor Name</th>
    <th>Rating</th>
    <th>Feedback</th>
    <th>Chat End Time</th>
    <th>Submitted At</th>
  </tr>

  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['client_name']) ?></td>
      <td><?= htmlspecialchars($row['doctor_name']) ?></td>
      <td><?= $row['rating'] ?> / 5</td>
      <td><?= htmlspecialchars($row['feedback']) ?></td>
      <td><?= htmlspecialchars($row['ended_at']) ?></td>
      <td><?= htmlspecialchars($row['submitted_at']) ?></td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
