<?php
include "../../includes/connection.php";
session_start();

// Ensure method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $speciality = $_POST['speciality'];
    $booking_price = $_POST['booking_price'];
    $chat_sessions_price = $_POST['chat_sessions_price'];
    $id_client = $_SESSION["id_user"];

    
    $file_path = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "cv_uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $original_name = basename($_FILES["file"]["name"]);
        $extension = pathinfo($original_name, PATHINFO_EXTENSION);
        $allowed = ['pdf', 'doc', 'docx'];

        if (!in_array(strtolower($extension), $allowed)) {
            die("Invalid file type. Allowed: PDF, DOC, DOCX");
        }

        $new_filename = uniqid("job_") . "." . $extension;
        $file_path = $upload_dir . $new_filename;

        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
            die("File upload failed.");
        }
    } else {
        die("File is required.");
    }

    // Prepare SQL Insert
    $stmt = $conn->prepare("INSERT INTO job_apply (title, description, file, booking_price, chat_sessions_price, stats, id_client, speciality)
                            VALUES (?, ?, ?, ?, ?, 'pending', ?, ?)");
    $stmt->bind_param("sssiiis", $title, $description, $file_path, $booking_price, $chat_sessions_price, $id_client, $speciality);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Application submitted successfully.</p>";
        echo "<a href='apply_job.php'>Apply Another</a>";
    } else {
        echo "<p style='color: red;'>Failed to submit application: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Job Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f9;
            padding: 40px;
        }
        .form-container {
            max-width: 600px;
            background: #fff;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            margin-bottom: 25px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }
        input[type="text"],
        input[type="number"],
        select,
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        button {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Apply for a Job</h2>
    <form action="jobApply.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div class="form-group">
            <label for="speciality">Speciality</label>
            <select name="speciality" required>
            <option value="">-- All Specialties --</option>
            <option value="Cardiologist">Cardiologist</option>
            <option value="Dermatologist">Dermatologist</option>
            <option value="Pediatrician">Pediatrician</option>
            <option value="Neurologist">Neurologist</option>
            <option value="General Physician">General Physician</option>
        </select>        </div>

        <div class="form-group">
            <label for="booking_price">Booking Price ($)</label>
            <input type="number" name="booking_price" id="booking_price" required>
        </div>

        <div class="form-group">
            <label for="chat_sessions_price">Chat Session Price ($)</label>
            <input type="number" name="chat_sessions_price" id="chat_sessions_price" required>
        </div>

        <div class="form-group">
            <label for="description">Short Description</label>
            <textarea name="description" id="description" maxlength="255" required></textarea>
        </div>

        <div class="form-group">
            <label for="file">Upload Resume or Portfolio</label>
            <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" required>
        </div>

        <button type="submit">Submit Application</button>
    </form>
</div>

</body>
</html>
