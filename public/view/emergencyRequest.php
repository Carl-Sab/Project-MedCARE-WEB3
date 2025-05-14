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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #00796b, #004d40);
            overflow: hidden;
            color: white;
        }

        .background {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .background .glow {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, #26a69a, transparent);
            filter: blur(150px);
            transform: translate(-50%, -50%);
            z-index: -1;
            animation: pulse 7s ease infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
            50% { transform: translate(-50%, -50%) scale(2); opacity: 0.7; }
        }

        .container {
            background-color: rgba(38, 166, 154, 0.3);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            padding: 30px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            animation: fadeInUp 1s ease forwards;
        }

        @keyframes fadeInUp { to { transform: translateY(0); opacity: 1; } }

        textarea, input[type="submit"] {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            color: black;
            border: 2px solid #004d40;
            backdrop-filter: blur(25px);
            outline: none;
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
        }

        input[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="background"><div class="glow"></div></div>
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