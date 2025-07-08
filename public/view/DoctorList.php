<?php
include "../../includes/connection.php";
session_start();

$user_id = $_SESSION['id_user'] ?? null;

$specialty_filter = isset($_GET['speciality']) ? $_GET['speciality'] : '';
$specialties_sql = "SELECT DISTINCT d.speciality FROM doctor d JOIN users u ON d.id_doctor = u.id_user WHERE u.role = 'doctor'";
$specialties_result = $conn->query($specialties_sql);

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
    <title>Find Your Doctor</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f8f9fc;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #00796b, #004d40);
            color: white;
            padding: 50px;
            text-align: center;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        header h2 {
            font-size: 36px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .back-btn {
            position: absolute;
            top: 15px;
            left: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: scale(1.05);
        }

        .main-content {
            background: white;
            border-radius: 12px;
            margin: -40px auto 30px;
            padding: 50px;
            max-width: 1100px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .filter-bar {
            text-align: center;
            margin-bottom: 30px;
        }

        .filter-bar select {
            padding: 14px;
            font-size: 16px;
            border-radius: 10px;
            border: 2px solid #00796b;
            background-color: #ffffff;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-bar select:hover {
            background: #e3f2fd;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }

        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid #00796b;
        }

        .card h3 {
            font-size: 22px;
            color: #00796b;
            margin: 10px 0 5px;
        }

        .card p {
            font-size: 16px;
            color: #555;
            margin: 6px 0;
        }

        .btn-group {
            margin-top: 15px;
        }

        .btn {
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            display: inline-block;
            margin: 8px;
            transition: all 0.3s ease;
        }

        .chat-btn {
            background-color: #43a047;
        }

        .book-btn {
            background-color: #0288d1;
        }

        .btn:hover {
            opacity: 0.9;
            transform: scale(1.07);
        }

        @media (max-width: 600px) {
            .main-content {
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<?php  include "../../includes/header.php"  ?>

<div class="main-content">
    <div class="filter-bar">
        <form method="GET" action="">
            <label for="speciality">Filter by Specialty:</label>
            <select name="speciality" onchange="this.form.submit();">
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
                <img class="profile-img" src="../images/uploads/<?= $row['PPicture']?>" alt="Doctor Image">
                <h3><?= $row['user_name'] ?></h3>
                <p><?= $row['speciality'] ?></p>
                <p>Consultation Fee: <?= "$" . $row['consultation_amount'] ?></p>
                <p>Booking Fee: <?= "$" . $row['booking_amount'] ?></p>

                <div class="btn-group">
                    <a class="btn chat-btn" href="paymentMethod.php?id_doctor=<?= $row['id_user'] ?>&type=consultation">Chat</a>
                    <a class="btn book-btn" href="bookAppointment.php?id_doctor=<?= $row['id_user'] ?>&type=booking">Book</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>