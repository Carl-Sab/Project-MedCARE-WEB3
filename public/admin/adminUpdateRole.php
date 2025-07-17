<?php
<<<<<<< Updated upstream
include "../../includes/connection.php";

if (isset($_POST['id_user'],$_POST['role'])) {
    $id_user = $_POST['id_user'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET role = '$role' WHERE id_user = $id_user";
    $conn->query($sql);
    header("Location: adminManageUser.php");
    exit();
=======
include "../../includes/security.php";
include "../../includes/connection.php";

if (isset($_POST['id_user'], $_POST['role'])) {
    $id_user = $_POST['id_user'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id_user = ?");
    $stmt->bind_param("si", $role, $id_user);
    if (!$stmt->execute()) {
        echo "Error in UPDATE users: " . $stmt->error;
    }

    if ($role !== "doctor") {
        $stmt = $conn->prepare("DELETE FROM doctor WHERE id_doctor = ?");
        $stmt->bind_param("i", $id_user);
        if (!$stmt->execute()) {
            echo "Error in DELETE doctor: " . $stmt->error;
        }
    }

    if ($role !== "client") {
        $stmt = $conn->prepare("DELETE FROM client WHERE id_client = ?");
        $stmt->bind_param("i", $id_user);
        if (!$stmt->execute()) {
            echo "Error in DELETE client: " . $stmt->error;
        }
    }

    $stmt = $conn->prepare("SELECT user_name FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    if (!$stmt->execute()) {
        echo "Error in SELECT user_name: " . $stmt->error;
    }
    $result = $stmt->get_result();
    $userName = $result->fetch_assoc()['user_name'] ?? '';

    if ($role === "doctor" && isset($_POST["speciality"], $_POST["consultation_amount"], $_POST["booking_amount"])) {
        $speciality = $_POST["speciality"];
        $consultation_amount = (int)$_POST["consultation_amount"];
        $booking_amount = (int)$_POST["booking_amount"];

        $stmt = $conn->prepare("INSERT INTO doctor (id_doctor, speciality, consultation_amount, booking_amount)
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii", $id_user, $speciality, $consultation_amount, $booking_amount);
        if ($stmt->execute()) {
            header("Location: adminManageUser.php");
        } else {
            die("Error in INSERT doctor: " . $conn->error);
        }

        exit();
    }

    if ($role === "client" && isset($_POST["blood_type"])) {
        $blood_type = $_POST["blood_type"];
        $health_condition = $_POST["health_condition"];

        $stmt = $conn->prepare("INSERT INTO client (id_client, blood_type, health_condition)
                                VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id_user, $blood_type, $health_condition);
        if (!$stmt->execute()) {
            echo "Error in INSERT client: " . $stmt->error;
        }

        header("Location: adminManageUser.php");
        exit();
    }

    if ($role === "admin") {
        header("Location: adminManageUser.php");
        exit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Enter <?php echo ucfirst($role); ?> Info</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: #f0f8f7;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .form-card {
                background: white;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                max-width: 500px;
                width: 100%;
            }
            h2 {
                margin-bottom: 20px;
                color: #004d40;
            }
            label {
                display: block;
                margin-top: 15px;
                color: #00695c;
            }
            input, select {
                width: 100%;
                padding: 10px;
                border: 2px solid #004d40;
                border-radius: 8px;
                margin-top: 5px;
                font-size: 1rem;
            }
            button {
                margin-top: 25px;
                width: 100%;
                padding: 12px;
                background: linear-gradient(to right, #00796b, #004d40);
                color: white;
                font-size: 16px;
                border: none;
                border-radius: 10px;
                cursor: pointer;
            }
            button:hover {
                background: #00695c;
            }
        </style>
    </head>
    <body>
    <div class="form-card">
        <h2>Enter <?php echo ucfirst($role); ?> Information</h2>
        <form method="POST">
            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
            <input type="hidden" name="role" value="<?php echo $role; ?>">

            <label>Name:</label>
            <input type="text" value="<?php echo htmlspecialchars($userName); ?>" readonly>

            <?php if ($role === "doctor"): ?>
                <label for="speciality">Speciality:</label>
                <select name="speciality" required>
                    <option value="">-- Select --</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Dermatologist">Dermatologist</option>
                    <option value="Pediatrician">Pediatrician</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="General Physician">General Physician</option>
                </select>

                <label for="consultation_amount">Consultation Amount:</label>
                <input type="number" name="consultation_amount" required>

                <label for="booking_amount">Booking Amount:</label>
                <input type="number" name="booking_amount" required>

            <?php elseif ($role === "client"): ?>
                <label for="blood_type">Blood Type:</label>
                <select name="blood_type" required>
                    <option value="">-- Select Blood Type --</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>

                <label for="health_condition">Health Condition:</label>
                <input type="text" name="health_condition" required>
            <?php endif; ?>

            <button type="submit">Save <?php echo ucfirst($role); ?> Info</button>
        </form>
    </div>
    </body>
    </html>

<?php
>>>>>>> Stashed changes
}
$conn->close();
?>
