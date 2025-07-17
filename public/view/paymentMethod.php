<?php

use function PHPSTORM_META\type;

include "../../includes/security.php";

include "../../includes/connection.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Payment</title>
    <link rel="stylesheet" href="../css/paymentMethod.css">

</head>
<body>
<div class="background">
  <div class="glow"></div>
</div>

<?php

if (isset($_GET["id_doctor"], $_GET["type"])) {
    if(isset($_GET['error'])){
        $error = $_GET['error'];
        echo "<script>alert('$error');</script>";
    }
    $id_doctor = $_GET["id_doctor"];
    $id_type = $_GET["type"];
    $id_user = $_SESSION['id_user'];

    $stmt = $conn->prepare("SELECT * FROM chat_sessions where id_user = ? AND id_doctor = ? AND status = 'active';");
    $stmt->bind_param("ii", $id_user, $id_doctor);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result && $result->num_rows > 0 && $id_type != "booking"){
        header("location:chatSystem.php");
        exit;
    }

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
