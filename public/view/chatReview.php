<?php
session_start();
include "../../includes/connection.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rating = $_POST['rating'] ?? null;
    $feedback = trim($_POST['feedback'] ?? '');
    $chat_session_id = $_GET['session'] ?? null;
    $id_user = $_SESSION['id_user'] ?? null;

    if ($rating && $feedback && $chat_session_id && $id_user) {
        $stmt = $conn->prepare("INSERT INTO review (id_user, chat_session_id, rating, feedback) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $id_user, $chat_session_id, $rating, $feedback);
        if ($stmt->execute()) {
            $success = "✅ Review submitted successfully.";
        } else {
            $error = "❌ Error submitting review: " . $conn->error;
        }
    } else {
        $error = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Review</title>
    <style>
        .star-rating {
            direction: rtl;
            display: inline-flex;
            font-size: 2rem;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            color: #ccc;
            cursor: pointer;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f5b301;
        }

        textarea {
            width: 100%;
            height: 100px;
            resize: vertical;
        }

        .feedback-form {
            max-width: 500px;
            margin: auto;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .message {
            text-align: center;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

<div class="feedback-form">
    <h2>Rate Your Chat Session</h2>

    <form method="post">
        <div class="star-rating">
            <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
            <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
            <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
            <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
            <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
        </div>

        <div>
            <label for="feedback">Feedback:</label><br>
            <textarea name="feedback" required></textarea>
        </div>

        <?php if (!empty($success)) echo "<div class='message' style='color: green;'>$success<a href='chatSystem.php'>back</div>"; ?>
        <?php if (!empty($error)) echo "<div class='message' style='color: red;'>$error</div>"; ?>

        <br>
        <button type="submit">Submit Review</button>
    </form>
</div>

</body>
</html>
