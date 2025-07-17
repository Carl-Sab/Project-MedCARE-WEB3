<?php
include "../../includes/security.php";

include "../../includes/connection.php";


// Ensure the client ID is passed
$client_id = $_GET['id_client'] ?? null;

// if (!$client_id) {
//     die("Client ID is missing.");
// }

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
$sql = "INSERT INTO test_result (id_client, id_doctor, result, date_result,fileName) VALUES (?, ?, ?, NOW(),?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("iiss", $client_id, $doctor_id, $test_result,$file_name);


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
    <link rel="stylesheet" href="../css/doctorTestResult.css">
</head>
<body>
    
<?php 
include "../../includes/header.php";
?>
<div id="container">
<div class="form-container">
    <h2>Submit Test Result</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" value="<?= htmlspecialchars($client_name) ?>" readonly>
        <input type="hidden" name="client_id" value="<?= $client_id ?>">
        <textarea name="test_result" placeholder="Enter Test Result..." required></textarea>
        <input type="file" name="test_file" required>
        <div class="button-container">
            <button type="submit">Submit</button>
            <button type="button"  id="back"><a href="doctorSelectClient.php">Back</a></button>
        </div>
    </form>
</div>
</div>
</body>
</html>
