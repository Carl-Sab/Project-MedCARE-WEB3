<?php
session_start();
include "../../includes/connection.php";

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor-Client Chat</title>
   <link rel="stylesheet" href="../css/chatSystem.css">
</head>
<body>
<!-- Sidebar for Contacts -->
<div class="sidebar">
    <h3>Doctors</h3>
    <?php
    if (isset($_SESSION["id_user"])) {
        $id_user = $_SESSION["id_user"];

        $sql = "SELECT u.*, c.*, d.*
                FROM chat_sessions c
                JOIN doctor d ON c.id_doctor = d.id_doctor
                JOIN users u ON d.id_doctor = u.id_user
                WHERE c.id_user = $id_user
                and c.status = 'active'
                ORDER BY c.chat_session_id DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $doc_id = $row['id_user'];
                $session_id = $row["chat_session_id"];
                $doc_name = htmlspecialchars($row['user_name']);
                $pic = $row['PPicture'] ? "../images/uploads/" . $row['PPicture'] : "../images/uploads/user.png";
                echo "
                <div class='contact' onclick=\"fetchMessages();currentSessionId = $session_id;openChat('$doc_name')\">
                    <img src='$pic' alt='Doctor Image'>
                    <span>$doc_name</span>
                    
                </div>";
            }
        } else {
            echo "<p>No doctors found.</p>";
        }
    } else {
        echo "<p>Please login to view your doctors.</p>";
    }
    ?>
</div>

<!-- Chat Section -->
<div class="chat-container">
    <div class="chat-header" id="chat-header">💬 Chat</div>

    <div class="chat-box" id="chat-box">
        <!-- ajax code will fetch here -->
    </div>
    <div class="chat-input">
            <input type="text" name="message" id="message-input" placeholder="Type your message..." required>
            <button type="submit" onclick="sendMessage()">Send</button>
    </div>
</div>

<script>

    let currentSessionId = null;
    function openChat(name){
        let doctorName = name;
        document.getElementById('chat-header').innerHTML="💬 Chat with "+ doctorName;
    }

    function fetchMessages() {
            if (!currentSessionId) return;
            console.log("Calling fetchMessages with sessionId:", currentSessionId);

            var msgContainer = document.getElementById("chat-box");

            const isNearBottom = msgContainer.scrollHeight - msgContainer.scrollTop <= msgContainer.clientHeight+100;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (msgContainer) {
                        msgContainer.innerHTML = xhr.responseText;
                        if (isNearBottom) {
                            msgContainer.scrollTop = msgContainer.scrollHeight;

                            let sessionStatus = document.getElementById("session-status");

                            if (sessionStatus && sessionStatus.dataset.ended === "true") {
                                document.getElementById("message-input").disabled = true;
                                document.querySelector(".chat-input button[type='submit']").disabled = true;
                                document.getElementById("end-session-btn").disabled = true;
                                let sessionStatus = document.getElementById('session-status');
                            }
                            else{
                                document.getElementById("message-input").disabled = false;
                                document.querySelector(".chat-input button[type='submit']").disabled = false;
                                document.getElementById("end-session-btn").disabled = false;
                            }

                        }
                    }
                }
            };
            xhr.open("GET", "getMessages.php?session=" + currentSessionId, true);
            xhr.send();
        }

        setInterval(fetchMessages, 2000);  

        function sendMessage() {
            const input = document.getElementById("message-input");
            const message = input.value.trim();

            if (!message || currentSessionId === null) return;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "setMessages.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    input.value = ""; // Clear input
                }
            };

         xhr.send("message=" + encodeURIComponent(message) + "&chat_session_id=" + currentSessionId);
        }

</script>

</body>
</html>
