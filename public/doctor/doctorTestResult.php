<?php
include "../../includes/connection.php";
session_start();

// Ensure the client ID is passed
$client_id = $_GET['id_client'] ?? null;

if (!$client_id) {
    die("Client ID is missing.");
}

// Fetch client name
$client_name = '';
$stmt = $conn->prepare("SELECT user_name FROM users WHERE id_user = ?");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$stmt->bind_result($client_name);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_SESSION['id_user'] ?? null;
    $test_result = $_POST['test_result'] ?? '';
    $file_name = '';

    if (!empty($_FILES['test_file']['name'])) {
        $file_name = time() . "_" . basename($_FILES['test_file']['name']);
        move_uploaded_file($_FILES['test_file']['tmp_name'], "../test_result_uploads/" . $file_name);
    }
$sql = "INSERT INTO test_result (id_client, id_doctor, result, date_result) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);  // ❗ Shows you the real reason for failure
}

$stmt->bind_param("iis", $client_id, $doctor_id, $test_result);


    if ($stmt->execute()) {
        echo "<script>alert('Test result submitted successfully!'); window.location.href='doctorSelectClient.php';</script>";
    } else {
        echo "<script>alert('Error submitting result: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Test Result</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #00796b, #004d40);
            color: white;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            padding: 35px;
            width: 420px;
            text-align: center;
        }
        .form-container h2 {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border-radius: 10px;
            border: 2px solid #004d40;
            background: white;
            font-size: 16px;
            color: black;
        }
        input[readonly] {
            background: #e0f2f1;
        }
        button {
            background: linear-gradient(135deg, #004d40, #26a69a);
            color: white;
            padding: 14px;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
        }
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Submit Test Result</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Client:</label>
        <input type="text" value="<?= htmlspecialchars($client_name) ?>" readonly>
        <input type="hidden" name="client_id" value="<?= $client_id ?>">
        <textarea name="test_result" placeholder="Enter Test Result..." required></textarea>
        <input type="file" name="test_file" required>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
