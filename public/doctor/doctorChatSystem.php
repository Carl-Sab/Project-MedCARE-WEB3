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
    <h3>Clients</h3>
    <?php
    if (isset($_SESSION["id_user"])) {
        $id_doctor = $_SESSION["id_user"]; // Assuming doctor is logged in

        $sql = "SELECT u.*, c.* 
                FROM chat_sessions c
                JOIN users u ON c.id_user = u.id_user
                WHERE c.id_doctor = $id_doctor
                GROUP BY u.id_user";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $client_id = $row['id_user'];
                $session_id = $row["chat_session_id"];
                $client_name = htmlspecialchars($row['user_name']);
                $pic = $row['PPicture'] ? "../images/uploads/" . $row['PPicture'] : "../../images/default.png";
                echo "
                <div class='contact' onclick=\"fetchMessages();currentSessionId = $session_id;openChat('$client_name')\">
                    <img src='$pic' alt='Client Image'>
                    <span>$client_name</span>
                </div>";
            }
        } else {
            echo "<p>No clients found.</p>";
        }
    } else {
        echo "<p>Please login to view your clients.</p>";
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
        <button id="end-session-btn" onclick="endSession(currentSessionId)">End Session</button>
        <input type="text" name="message" id="message-input" placeholder="Type your message..." required>
        <button type="submit" onclick="sendMessage()">Send</button>
    </div>
</div>
</body>
    <script>
        let currentSessionId = null;
        var msgContainer = document.getElementById("chat-box");
        msgContainer.scrollTop = msgContainer.scrollHeight;


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
                            }
                            else{
                                document.getElementById("message-input").disabled = false;
                                document.querySelector(".chat-input button[type='submit']").disabled = false;
                                document.getElementById("end-session-btn").disabled = false;
                            }

                        }

                    }
                }
            }
            xhr.open("GET", "doctorGetMessages.php?session=" + currentSessionId, true);
            xhr.send();
        };
        
        setInterval(fetchMessages, 2000);

        function sendMessage() {
            const input = document.getElementById("message-input");
            const message = input.value.trim();

            if (!message || currentSessionId === null) return;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "doctorSetMessages.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    input.value = "";
                }
            };

            xhr.send("message=" + encodeURIComponent(message) + "&chat_session_id=" + currentSessionId);
        }

        function openChat(name){
            let client = name;
            document.getElementById('chat-header').innerHTML="💬 Chat with "+ client;
        }
        function endSession(){
            console.log(currentSessionId);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "endSession.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {

                    console.log("session ended succesfully");

                }
            };

            xhr.send("chat_session_id=" + currentSessionId);
        }

    
    </script>
</html>
