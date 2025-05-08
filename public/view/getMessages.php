<?php
include "../../includes/connection.php";
session_start();

if (isset($_GET['session']) && isset($_SESSION['id_user'])) {
    $id_session = $_GET['session'];
    $id_user = $_SESSION['id_user'];
    $stmt = $conn->prepare("SELECT * FROM message WHERE chat_session_id = ? ORDER BY date_time ASC");
    $stmt->bind_param("i", $id_session);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $msg = htmlspecialchars($row['message']);
        $sender = $row['id_sender'];

        if ($sender == $id_user) {
            echo "<div class='message me'>{$msg}</div>";
        } else {
            echo "<div class='message him'>{$msg}</div>";
        }
    }
}
?>
