<?php
include "../../includes/security.php";
include "../../includes/connection.php";


$id_user = $_SESSION['id_user'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blood_type = $_POST['blood_type'] ?? '';

    if ($blood_type) {
        $stmt = $conn->prepare("INSERT INTO blood_request (id_requester, blood_type, date_request, status) VALUES (?, ?, NOW(), 'pending')");
        $stmt->bind_param("is", $id_user, $blood_type);
        if($stmt->execute()){
            echo "<script>alert('Blood request submitted successfully!');</script>";
        }
        else{
          echo "<script>alert('".$conn->error."');</script>";
        }
    } else {
        echo "<script>alert('Please select a blood type.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Request Blood</title>
  <link rel="stylesheet" href="../css/requestBlood.css">
</head>
<body>

<?php include "../../includes/header.php"; ?>

<div class="main-content">
  <div class="form-container">
    <h2>Request Blood</h2>
    <form method="POST">
      <label for="blood_type">Select Blood Type:</label>
      <select name="blood_type" id="blood_type" required>
        <option value="" disabled selected>-- Choose Blood Type --</option>
        <?php
        $types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        foreach ($types as $type) {
            echo "<option value=\"$type\">$type</option>";
        }
        ?>
      </select>
      <br>
      <button type="submit">Submit Request</button>
    </form>
  </div>
</div>

</body>
</html>
