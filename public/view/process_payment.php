<?php
include "../../includes/connection.php";
session_start();

if (isset($_POST['id_doctor'], $_POST['type'], $_POST['amount'], $_POST['card_number'], $_POST['card_pass'])) {

    $id_doctor = (int)$_POST['id_doctor'];
    $type = $_POST['type'];
    $amount = (float)$_POST['amount'];
    $card_number = $_POST['card_number'];
    $card_pass = $_POST['card_pass'];
    $id_user = $_SESSION["id_user"] ?? null;

    if (!$id_user) {
        die("User not logged in.");
    }

    $stmt = $conn->prepare("SELECT balance FROM bank WHERE id_card = ? AND pass = ?");
    $stmt->bind_param("is", $card_number, $card_pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $balance = $row["balance"];

        if ($balance >= $amount) {
            $new_balance = $balance - $amount;

            $stmt = $conn->prepare("UPDATE bank SET balance = ? WHERE id_card = ?");
            $stmt->bind_param("di", $new_balance, $card_number);
            $stmt->execute();

            $admin_percent = $amount*0.1;
            $stmt = $conn->prepare("INSERT INTO payments (id_client, id_doctor, amount, admin_percentage, payment_date) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("iidi", $id_user, $id_doctor, $amount, $admin_percent);
            $stmt->execute();

            if ($type === 'consultation') {
                $stmt = $conn->prepare("INSERT INTO chat_sessions (id_user, id_doctor, started_at) VALUES (?, ?, NOW())");
                $stmt->bind_param("ii", $id_user, $id_doctor);
                $stmt->execute();
            }

            header("location:chatSystem.php");
        } else {
            $error = "Insufficient balance";
            header("location:paymentMethod.php?id_doctor=$id_doctor&type=$type&error=$error");
        }
    } else {
        $error ="Invalid card credentials.";
        header("location:paymentMethod.php?id_doctor=$id_doctor&type=$type&error=$error");

    }
} else {
    $error = "Required fields missing.";
    header("location:paymentMethod.php?id_doctor=$id_doctor&type=$type&error=$error");

}
?>
