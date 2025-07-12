<?php
session_start();
include "../../includes/connection.php";
include "../../includes/security.php";


if (isset($_SESSION['id_user']) && isset($_POST['message']) && isset($_POST['chat_session_id'])) {
    $id_user = $_SESSION['id_user'];
    $message = htmlspecialchars($_POST['message']);
    $session_id = intval($_POST['chat_session_id']);

    if (!empty($message)) {

        $stmt = $conn->prepare("INSERT INTO message (chat_session_id, id_sender, message, date_time) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $session_id, $id_user, $message);

        if ($stmt->execute()) {
            echo "Message sent successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Message cannot be empty.";
    }
} else {
    echo "Invalid session or missing parameters.";
}

$conn->close();
?>
