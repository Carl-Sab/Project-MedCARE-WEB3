<?php
session_start();
include "../../includes/connection.php";

$id_user = $_SESSION['id_user'];

// Get donor's blood type
$stmt = $conn->prepare("SELECT blood_type FROM client WHERE id_client = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$stmt->bind_result($donor_blood_type);
$stmt->fetch();
$stmt->close();

// Handle approve/decline actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id_blood_req'])) {
    $action = $_POST['action'];
    $id_blood_req = intval($_POST['id_blood_req']);

    if ($action === 'approve') {
        // Check if already approved
        $check = $conn->prepare("SELECT * FROM blood_transaction WHERE id_blood_req = ? AND id_donor = ?");
        $check->bind_param("ii", $id_blood_req, $id_user);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows === 0) {
            // Insert approval
            $insert = $conn->prepare("INSERT INTO blood_transaction (id_blood_req, id_donor, date_transaction) VALUES (?, ?, NOW())");
            $insert->bind_param("ii", $id_blood_req, $id_user);
            $insert->execute();
            $insert->close();

            // Update request status
            $update = $conn->prepare("UPDATE blood_request SET status = 'approved' WHERE id_blood_req = ?");
            $update->bind_param("i", $id_blood_req);
            $update->execute();
            $update->close();

            echo "<script>alert('You have approved this blood request.');</script>";
        } else {
            echo "<script>alert('You already approved this request.');</script>";
        }
        $check->close();

    } elseif ($action === 'decline') {
        $update = $conn->prepare("UPDATE blood_request SET status = 'declined' WHERE id_blood_req = ?");
        $update->bind_param("i", $id_blood_req);
        $update->execute();
        $update->close();

        echo "<script>alert('You have declined this blood request.');</script>";
    }
}

// Fetch pending requests matching donor's blood type
$stmt = $conn->prepare("SELECT br.id_blood_req, u.user_name, br.blood_type, br.date_request 
                        FROM blood_request br 
                        JOIN users u ON br.id_requester = u.id_user
                        WHERE br.blood_type = ? AND br.status = 'pending'");
$stmt->bind_param("s", $donor_blood_type);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Requests for Donors</title>
    <link rel="stylesheet" href="../css/donorRequest.css">
</head>
<body>
<?php include "../../includes/header.php" ?>

<h2>Pending Blood Requests for Blood Type <?= htmlspecialchars($donor_blood_type) ?></h2>

<?php if ($result->num_rows > 0): ?>
<table border="1" cellpadding="10">
    <tr>
        <th>Requester Name</th>
        <th>Blood Type</th>
        <th>Date Requested</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['user_name']) ?></td>
        <td><?= htmlspecialchars($row['blood_type']) ?></td>
        <td><?= htmlspecialchars($row['date_request']) ?></td>
        <td>
            <form method="POST" style="display:inline">
                <input type="hidden" name="id_blood_req" value="<?= $row['id_blood_req'] ?>" />
                <button type="submit" name="action" value="approve">Donate</button>
            </form>
            <form method="POST" style="display:inline">
                <input type="hidden" name="id_blood_req" value="<?= $row['id_blood_req'] ?>" />
                <button type="submit" name="action" value="decline">Decline</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p>No pending requests matching your blood type.</p>
<?php endif; ?>

</body>
</html>
