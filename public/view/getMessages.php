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
    $checkSession = "SELECT status from chat_sessions WHERE chat_session_id = $id_session";
    $result = $conn->query($checkSession);
    
    if (!$result) {
        die("Error in query: " . $conn->error);
    }
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $flag = $row['status'];
        if ($flag === 'ended') {
            echo "<div id='session-status' data-ended='true' style='text-align:center;'>session ended <a href='chatReview.php?session=$id_session'>Review</a></div>";
        } else {
            echo "<div id='session-status' data-ended='false'></div>";
        }
    }
    
}
?>
