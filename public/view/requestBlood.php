<?php
session_start();
include "../../includes/connection.php";

$id_user = $_SESSION['id_user'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blood_type = $_POST['blood_type'] ?? '';

    if ($blood_type) {
        $stmt = $conn->prepare("INSERT INTO blood_request (id_requester, blood_type, date_request, status) VALUES (?, ?, NOW(), 'pending')");
        $stmt->bind_param("is", $id_user, $blood_type);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Blood request submitted successfully!');</script>";
    } else {
        echo "<script>alert('Please select a blood type.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Request Blood</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f0f0f0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Keep header at the top */
    header {
      flex-shrink: 0;
    }

    .main-content {
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-container {
      background: rgba(0, 121, 107, 0.2);
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
      color: #004d40;
    }

    label {
      font-weight: bold;
      display: block;
      margin-bottom: 10px;
    }

    select {
      padding: 10px;
      width: 200px;
      border-radius: 5px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
    }

    button {
      background: #00796b;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s ease;
    }

    button:hover {
      background: #004d40;
    }
  </style>
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
