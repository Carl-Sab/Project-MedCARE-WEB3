<?php
include "../../includes/connection.php";
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/paymentMethod.css">
</head>
<body>

<div class="background">
    <div class="glow"></div>
</div>

<div class="payment-box">
    <h2>Pay for <?php //ucfirst($id_type); ?> with Dr. <?php //htmlspecialchars($doctor_name); ?></h2>
    <p>Amount to pay: <strong>$<?php //number_format($amount, 2); ?></strong></p>

    <form action="process_payment.php" method="POST">
        <input type="hidden" name="id_doctor" value="<?php //$id_doctor; ?>">
        <input type="hidden" name="type" value="<?php //htmlspecialchars($id_type); ?>">
        <input type="hidden" name="amount" value="<?php //$amount; ?>">

        <input type="text" id="card_number" name="card_number" placeholder="Card Number" required>
        <input type="password" id="card_pass" name="card_pass" placeholder="Card Password" required>

        <button type="submit" id="pay-button">Proceed to Pay</button>
    </form>
</div>

</body>
</html>