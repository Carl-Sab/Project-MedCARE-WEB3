<?php
include "../../includes/security.php";

include "../../includes/connection.php";


if(isset($_POST['chat_session_id'])){
    $sessionID = $_POST['chat_session_id'];
    $update = "UPDATE chat_sessions set ended_at = NOW() , status = 'ended' where chat_session_id = $sessionID;";
    $conn->query($update);

}