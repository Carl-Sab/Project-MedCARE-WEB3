<?php

include "../../includes/connection.php";
session_start();

if(isset($_POST['id_doctor'],$_POST['type'],$_POST['amount'],$_POST['card_number'],$_POST['card_pass'])){

    $id_doctor = $_POST['id_doctor'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $card_number = $_POST['card_number'];
    $card_pass = $_POST['card_pass'];
    $id_user = $_SESSION["id_user"];

    $sql = "SELECT * from bank where id_card = ? AND pass = ? ;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is",$card_number,$card_pass);
    $stmt->execute();
    if($stmt->num_rows()>0){
        $balance = $row["balance"]-$amount;
        $update = "UPDATE bank set balance  = ? where id_card = ?;";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("ii",$balance,$card_number);
        $stmt->execute();

        $insert1 = "INSERT INTO payments (`id_client`,`id_doctor`,`amount`,`admin_percentage`,`payment_date`)VALUES (?,?,?,?,NOW())";
        $stmt = $conn->prepare($insert1);
        $stmt->bind_param("iiiii",$id_user,$id_doctor,$amount,10);
        $stmt->execute();

        $insert2 = "INSERT INTO chat_sessions (`id_user`,`id_doctor`,`started_at`)VALUES(?,?,NOW())";
        $stmt = $conn->prepare($inser2);
        $stmt->bind_param("ii",$id_user,$id_doctor);
        $stmt->execute();
    }


}