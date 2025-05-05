<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor-Client Chat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            background: radial-gradient(circle, #00796b 20%, #004d40 90%);
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .chat-container {
            width: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(12px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .chat-header {
            font-size: 20px;
            font-weight: bold;
            padding: 15px;
            background: rgba(255, 255, 255, 0.2);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .chat-box {
            height: 300px;
            overflow-y: auto;
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .message {
            max-width: 75%;
            padding: 12px;
            border-radius: 12px;
            font-size: 15px;
            position: relative;
            animation: slideUp 0.4s ease-in-out;
        }

        .client {
            background: linear-gradient(135deg, #ffffff, #00e676);
            color: #00796b;
            align-self: flex-start;
        }

        .doctor {
            background: linear-gradient(135deg, #00796b, #004d40);
            color: white;
            align-self: flex-end;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .chat-input {
            display: flex;
            gap: 10px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.15);
        }

        input {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.3);
            color: #00796b;
            font-weight: bold;
            transition: 0.3s;
        }

        input:focus {
            background: rgba(255, 255, 255, 0.5);
        }

        button {
            background-color: #00e676;
            color: #00796b;
            cursor: pointer;
            font-weight: bold;
            border-radius: 8px;
            padding: 12px;
            border: none;
            transition: 0.3s;
        }

        button:hover {
            background-color: #004d40;
            color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">💬 Doctor-Client Chat</div>
    
    <div class="chat-box" id="chat-box">
        <div class="message client">Hello, doctor! I have a question.</div>
        <div class="message doctor">Sure! How can I assist you?</div>
    </div>

    <div class="chat-input">
        <input type="text" id="message-input" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
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
            doctorMessage.innerText = "I see! Let's discuss.";
            chatBox.appendChild(doctorMessage);
            chatBox.scrollTop = chatBox.scrollHeight;
        }, 1000);
    }
</script>

</body>
</html>