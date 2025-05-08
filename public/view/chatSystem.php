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

        $sql = "SELECT u.*,c.*,d.* 
                FROM chat_sessions c
                JOIN doctor d ON c.id_doctor = d.id_doctor
                JOIN users u ON d.id_doctor = u.id_user
                WHERE c.id_user = $id_user
                GROUP BY u.id_user";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $doc_id = $row['id_user'];
                $doc_name = htmlspecialchars($row['user_name']);
                $pic = $row['PPicture'] ? "../images/" . $row['PPicture'] : "../../images/default.png";
                echo "
                <div class='contact' onclick=\"changeChat('$doc_name')\">
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
    <div class="chat-header" id="chat-header">💬 Chat with Dr. Smith</div>

    <div class="chat-box" id="chat-box">
        <div class="message client">Hello, doctor! I need some advice.</div>
        <div class="message doctor">Sure! What would you like to discuss?</div>
    </div>

    <div class="chat-input">
        <form action="getMessages.php" method="POST" style="width: 100%;" onsubmit="event.preventDefault(); sendMessage();">
            <input type="text" name="message" id="message-input" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>
</div>

<script>
    function changeChat(doctorName) {
        document.getElementById("chat-header").innerText = "💬 Chat with " + doctorName;
        document.getElementById("chat-box").innerHTML = `
            <div class="message client">Hello ${doctorName}, how are you?</div>
            <div class="message doctor">Hello! How can I assist you today?</div>
        `;
    }

    function sendMessage() {
        let input = document.getElementById("message-input");
        let messageText = input.value.trim();
        if (messageText === "") return;

        let chatBox = document.getElementById("chat-box");
        let messageDiv = document.createElement("div");
        messageDiv.className = "message client";
        messageDiv.innerText = messageText;

        chatBox.appendChild(messageDiv);
        input.value = "";

        chatBox.scrollTop = chatBox.scrollHeight;

        // Simulated reply
        setTimeout(() => {
            let doctorMessage = document.createElement("div");
            doctorMessage.className = "message doctor";
            doctorMessage.innerText = "Okay! Let's figure it out together.";
            chatBox.appendChild(doctorMessage);
            chatBox.scrollTop = chatBox.scrollHeight;
        }, 1000);
    }
</script>

</body>
</html>
