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
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .filter-bar {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-bar select {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .profile-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 2px solid #ccc;
        }

        .card h3 {
            margin: 10px 0 5px;
            font-size: 20px;
            color: #007bff;
        }

        .card p {
            margin: 5px 0 15px;
            color: #555;
            font-size: 16px;
        }

        .btn {
            text-decoration: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            margin: 5px;
            display: inline-block;
            font-size: 14px;
        }

        .chat-btn {
            background-color: #28a745;
        }

        .book-btn {
            background-color: #007bff;
        }
    </style>
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
            <img class="profile-img" 
                 src="../images/<?= $row['PPicture']?>" 
                 alt="Doctor Image">
            <h3><?= $row['user_name'] ?></h3>
            <p><?= $row['speciality'] ?></p>
            <p>consultation_amount:<?= " ".$row['consultation_amount'] ?></p>
            <p>booking_amount:<?= " ".$row['booking_amount'] ?></p>

            <a class="btn chat-btn" href="paymentMethod.php?id_doctor=<?= $row['id_user'] ?>&type=consultation">Chat</a>
            <a class="btn book-btn" href="paymentMethod.php?id_doctor=<?= $row['id_user'] ?>&type=booking">Book</a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
