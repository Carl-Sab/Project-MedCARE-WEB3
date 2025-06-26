<?php
session_start();
include '../../includes/connection.php';

// Assuming user is logged in and session contains user id
$id_client = $_SESSION['id_user']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reason = $_POST['reason'];
    $date_emergency = date("Y-m-d H:i:s");
    $status = 'Pending';

    $stmt = $conn->prepare("INSERT INTO emergency (id_client, reason, date_emergency, stats) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id_client, $reason, $date_emergency, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Emergency request submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Emergency Request</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: white;
    color: white;
}

.container {
    background-color: rgba(38, 166, 154, 0.3);
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    padding: 30px;
    width: 90%;
    max-width: 450px;
    text-align: center;
    margin: 80px auto 0 auto; /* spacing below header */
    animation: fadeInUp 1s ease forwards;
}

@keyframes fadeInUp {
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

textarea, input[type="submit"] {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    font-size: 16px;
    color: black;
    border: 2px solid #004d40;
    background: white;
    transition: border-color 0.3s, box-shadow 0.3s, transform 0.3s ease;
    box-sizing: border-box;
}

textarea:focus, input[type="submit"]:focus {
    border-color: #004d40;
    box-shadow: 0 0 10px #004d40;
}

input[type="submit"] {
    background: linear-gradient(135deg, #004d40, #26a69a);
    color: white;
    cursor: pointer;
    margin-top: 10px;
}

input[type="submit"]:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
}

    </style>
</head>
<body>
    <?php include "../../includes/header.php";  ?>
    <div class="container">
        <h2>Submit Emergency Request</h2>
        <form method="POST" action="">
            <label for="reason">Reason for Emergency:</label><br>
            <textarea name="reason" id="reason" rows="5" required></textarea><br><br>
            <input type="submit" value="Submit Request">
        </form>
    </div>
</body>
</html>