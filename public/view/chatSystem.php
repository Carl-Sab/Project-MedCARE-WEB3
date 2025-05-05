<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor-Client Chat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            height: 100vh;
            background: #FFFFFF;
            color: #004d40;
        }

        .sidebar {
            width: 30%;
            background: #F1F1F1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            font-size: 20px;
            margin-bottom: 15px;
            text-align: center;
            color: #00796b;
        }

        .contact {
            padding: 14px;
            border-radius: 12px;
            background: rgba(0, 121, 107, 0.1);
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact:hover {
            background: rgba(0, 121, 107, 0.3);
        }

        .contact img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .chat-container {
            width: 70%;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .chat-header {
            font-size: 22px;
            font-weight: bold;
            padding: 15px;
            background: #00796b;
            color: white;
            text-align: center;
            border-radius: 8px;
        }

        .chat-box {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #F9F9F9;
            border-radius: 10px;
        }

        .message {
            max-width: 65%;
            padding: 12px;
            border-radius: 20px;
            font-size: 16px;
            transition: 0.3s ease-in-out;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.15);
        }

        .client {
            background: #A3E635;
            color: #004d40;
            align-self: flex-start;
        }

        .doctor {
            background: #00796b;
            color: white;
            align-self: flex-end;
        }

        .chat-input {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: #F1F1F1;
            box-shadow: 0 -5px 10px rgba(0, 0, 0, 0.1);
        }

        input {
            flex: 1;
            padding: 12px;
            border: 2px solid #00796b;
            border-radius: 12px;
            font-size: 16px;
        }

        button {
            background-color: #00796b;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 12px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }

        @media (max-width: 800px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: 120px;
                flex-direction: row;
                overflow-x: auto;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 10px;
            }

            .chat-container {
                width: 100%;
            }

            .contact {
                padding: 10px;
                font-size: 14px;
            }

            .contact img {
                width: 35px;
                height: 35px;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar for Contacts -->
<div class="sidebar">
    <h3>Doctors</h3>
    <div class="contact" onclick="changeChat('Dr. Smith')">
        <img src="doctor1.jpg" alt="Dr. Smith"> Dr. Smith
    </div>
    <div class="contact" onclick="changeChat('Dr. Johnson')">
        <img src="doctor2.jpg" alt="Dr. Johnson"> Dr. Johnson
    </div>
    <div class="contact" onclick="changeChat('Dr. Williams')">
        <img src="doctor3.jpg" alt="Dr. Williams"> Dr. Williams
    </div>
</div>

<!-- Chat Section -->
<div class="chat-container">
    <div class="chat-header" id="chat-header">💬 Chat with Dr. Smith</div>

    <div class="chat-box" id="chat-box">
        <div class="message client">Hello, doctor! I need some advice.</div>
        <div class="message doctor">Sure! What would you like to discuss?</div>
    </div>

    <div class="chat-input">
        <input type="text" id="message-input" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
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