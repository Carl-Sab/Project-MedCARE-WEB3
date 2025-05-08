<?php
include "../../includes/connection.php";
session_start();

$user_id = $_SESSION['id_user'] ?? null;

// Get list of unique specialties
$specialty_filter = isset($_GET['speciality']) ? $_GET['speciality'] : '';
$specialties_sql = "SELECT DISTINCT d.speciality FROM doctor d JOIN users u ON d.id_doctor = u.id_user WHERE u.role = 'doctor'";
$specialties_result = $conn->query($specialties_sql);

// Fetch doctors (with optional filter)
$sql = "SELECT u.*, d.* FROM users u 
        JOIN doctor d ON u.id_user = d.id_doctor 
        WHERE u.role = 'doctor'";

if (!empty($specialty_filter)) {
    $specialty_filter_escaped = $conn->real_escape_string($specialty_filter);
    $sql .= " AND d.speciality = '$specialty_filter_escaped'";
}

$result = $conn->query($sql);
if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor List - User Panel</title>

  <link rel="stylesheet" href="../css/doctorList.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #00796b, #004d40);
            color: white;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center;
        }

        .filter-bar {
            text-align: center;
            margin-bottom: 25px;
        }

        .filter-bar select {
            padding: 10px;
            font-size: 18px;
            border-radius: 8px;
            border: none;
            background-color: #ffffff;
            color: #00796b;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1200px;
            width: 100%;
            margin-top: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            padding: 25px;
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3);
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid #ffffff;
        }

        .card h3 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 18px;
            margin: 5px 0;
        }

        .btn {
            text-decoration: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            display: inline-block;
            transition: all 0.3s ease-in-out;
        }

        .chat-btn {
            background-color: #28a745;
        }

        .book-btn {
            background-color: #007bff;
        }

        .btn:hover {
            transform: scale(1.08);
            opacity: 0.9;
        }
    </style>
>>>>>>> origin/Roger
</head>
<body>

<h2>Find a Doctor</h2>

<div class="filter-bar">
    <form method="GET" action="">
        <label for="speciality">Filter by Specialty:</label>
        <select name="speciality" onchange="this.form.submit();event.preventDefault();">
            <option value="">-- All Specialties --</option>
            <option value="Cardiologist">Cardiologist</option>
            <option value="Dermatologist">Dermatologist</option>
            <option value="Pediatrician">Pediatrician</option>
            <option value="Neurologist">Neurologist</option>
            <option value="General Physician">General Physician</option>
        </select>
    </form>
</div>

<div class="doctors-grid">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
            <img class="profile-img" src="../images/<?= $row['PPicture']?>" alt="Doctor Image">
            <h3><?= $row['user_name'] ?></h3>
            <p><?= $row['speciality'] ?></p>
            <p>Consultation Fee: <?= "$" . $row['consultation_amount'] ?></p>
            <p>Booking Fee: <?= "$" . $row['booking_amount'] ?></p>

            <a class="btn chat-btn" href="paymentMethod.php?id_doctor=<?= $row['id_user'] ?>&type=consultation">Chat</a>
            <a class="btn book-btn" href="paymentMethod.php?id_doctor=<?= $row['id_user'] ?>&type=booking">Book</a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
