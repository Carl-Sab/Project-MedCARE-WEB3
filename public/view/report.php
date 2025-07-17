<?php
include "../../includes/security.php";

include "../../includes/connection.php";


if (isset($_POST['subject'], $_POST["description"])) {
    $id_user = $_SESSION['id_user'];
    $title = $_POST['subject'];
    $desc = $_POST["description"];

    $insert = "INSERT INTO report (id_client,title,description,date_of_post) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("iss", $id_user, $title, $desc);

    if ($stmt->execute()) {
        header("Location: ./homepage.php");
        exit(); // Always add exit() after header redirects
    } else {
        echo "<script>alert('Failed to submit report.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report an Issue</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }

        /* Fixed Header */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #004d40;
            color: white;
            padding: 15px 20px;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        /* Container below header */
        .page-container {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px);
            padding: 20px;
        }

        .form-container {
            background-color: rgba(38, 166, 154, 0.3);            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 25px;
            max-width: 400px;
            width: 100%;
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #004d40;
            font-size: 22px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #fdfdfd;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus, textarea:focus {
            border-color: #00796b;
            box-shadow: 0 0 6px rgba(0, 121, 107, 0.3);
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        button:hover {
            background: linear-gradient(90deg, #00695c, #00332f);
            transform: translateY(-2px);
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }

            .form-container h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<?php include "../../includes/header.php"; ?>

<div class="page-container">
    <div class="form-container">
        <h2>Report an Issue</h2>
        <form action="report.php" method="POST">
            <div class="form-group">
                <label for="subject">Report Subject</label>
                <input type="text" name="subject" id="subject" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" maxlength="500" required></textarea>
            </div>

            <button type="submit">Submit Report</button>
        </form>
    </div>
</div>

</body>
</html>
