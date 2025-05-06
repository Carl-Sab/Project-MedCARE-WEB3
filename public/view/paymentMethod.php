<?php
include "../../includes/connection.php";
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6f9;
            padding: 30px;
        }
        .payment-box {
            max-width: 500px;
            background: #fff;
            margin: auto;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .payment-box h2 {
            margin-bottom: 20px;
        }
        .payment-box p {
            margin: 10px 0;
        }
        .payment-box input[type="text"],
        .payment-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .payment-box button {
            width: 100%;
            background: #007bff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .payment-box button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<?php
if (isset($_GET["id_doctor"], $_GET["type"])) {
    $id_doctor = $_GET["id_doctor"];
    $id_type = $_GET["type"];

    $stmt = $conn->prepare("SELECT d.*, u.user_name FROM doctor d JOIN users u ON u.id_user = d.id_doctor WHERE d.id_doctor = ?");
    $stmt->bind_param("i", $id_doctor);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $doctor_name = $row["user_name"];
        $amount = ($id_type == "consultation") ? $row["consultation_amount"] : $row["booking_amount"];
        ?>

        <div class="payment-box">
            <h2>Pay for <?= ucfirst($id_type); ?> with Dr. <?= htmlspecialchars($doctor_name); ?></h2>
            <p>Amount to pay: <strong>$<?= number_format($amount, 2); ?></strong></p>

            <form action="process_payment.php" method="POST">
                <input type="hidden" name="id_doctor" value="<?= $id_doctor; ?>">
                <input type="hidden" name="type" value="<?= htmlspecialchars($id_type); ?>">
                <input type="hidden" name="amount" value="<?= $amount; ?>">

                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>

                <label for="card_pass">Card Password:</label>
                <input type="password" id="card_pass" name="card_pass" placeholder="••••••••" required>

                <button type="submit">Proceed to Pay</button>
            </form>
        </div>

        <?php
    } else {
        echo "<p class='error'>Doctor not found.</p>";
    }
} else {
    echo "<p class='error'>Missing doctor ID or type in the URL.</p>";
}
?>

</body>
</html>
