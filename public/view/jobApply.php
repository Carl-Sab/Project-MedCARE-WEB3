<?php
include "../../includes/connection.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(90deg, #00796b, #004d40);
            overflow: hidden;
            color: white;
            padding: 15px;
        }

        .background {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .background .glow {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, #26a69a, transparent);
            filter: blur(100px);
            transform: translate(-50%, -50%);
            z-index: -1;
            animation: pulse 7s ease infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }
            50% {
                transform: translate(-50%, -50%) scale(1.6);
                opacity: 0.7;
            }
        }

        .form-container {
            background-color: rgba(38, 166, 154, 0.3);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: translateY(40px);
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
            color: white;
        }

        @keyframes fadeInUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-container h2 {
            font-size: 22px;
            margin-bottom: 15px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 10px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, select, textarea {
            width: 90%;
            padding: 8px;
            border-radius: 6px;
            border: 2px solid rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.6);
            outline: none;
            font-size: 14px;
            color: #222;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        textarea {
            min-height: 60px;
            resize: vertical;
        }

        input:focus, textarea:focus {
            border-color: darkgreen;
            box-shadow: 0 0 8px rgba(0, 86, 179, 0.6);
        }

        button {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(90deg, #00796b, #004d40);
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }

        @media (max-width: 768px) {
            .form-container {
                background-color: transparent;
                box-shadow: 0px 0px 0px 0px;
                padding: 15px;
                max-width: 350px;
                border:none;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                border:none;
                background-color: transparent;
                box-shadow: 0px 0px 0px 0px;
                padding: 12px;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>

<div class="background">
    <div class="glow"></div>
</div>

<div class="form-container">
    <h2>Apply for a Job</h2>
    <form action="jobApply.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div class="form-group">
            <label for="speciality">Speciality</label>
            <select name="speciality" required>
                <option value="">-- All Specialties --</option>
                <option value="Cardiologist">Cardiologist</option>
                <option value="Dermatologist">Dermatologist</option>
                <option value="Pediatrician">Pediatrician</option>
                <option value="Neurologist">Neurologist</option>
                <option value="General Physician">General Physician</option>
            </select>
        </div>

        <div class="form-group">
            <label for="booking_price">Booking Price ($)</label>
            <input type="number" name="booking_price" id="booking_price" required>
        </div>

        <div class="form-group">
            <label for="chat_sessions_price">Chat Session Price ($)</label>
            <input type="number" name="chat_sessions_price" id="chat_sessions_price" required>
        </div>

        <div class="form-group">
            <label for="description">Short Description</label>
            <textarea name="description" id="description" maxlength="255" required></textarea>
        </div>

        <div class="form-group">
            <label for="file">Upload Resume or Portfolio</label>
            <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" required>
        </div>

        <button type="submit">Submit Application</button>
    </form>
</div>

</body>
</html>