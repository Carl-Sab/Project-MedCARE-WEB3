<?php
session_start();
include "../../includes/connection.php";

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/chatReview.css">
</head>
<body>
 
   <?php
   include "../../includes/header.php";
   ?> 
   
<div class="review-container">
    <div class="review-card">
        <h2>Rate Your Chat Session</h2>
        <form method="post">
            <div class="star-rating">
                <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
                <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
                <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
                <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
                <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
            </div>
            <textarea name="feedback" placeholder="Write your feedback..." required></textarea>
            <?php if (!empty($success)) echo "<div class='message' style='color: lightgreen;'>$success <a href='chatSystem.php'>Back</a></div>"; ?>
            <?php if (!empty($error)) echo "<div class='message' style='color: red;'>$error</div>"; ?>
            <button type="submit">Submit Review</button>
        </form>
    </div>
</div>
</body>
</html>
