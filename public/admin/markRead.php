<?php
<<<<<<< Updated upstream
include "../../includes/connection.php";
=======
include "../../includes/security.php";
include "../../includes/connection.php";

>>>>>>> Stashed changes

if (isset($_POST['id_report'])) {
    $id = $_POST['id_report'];
    $update = "UPDATE report SET stats = 'readed' WHERE id_report = $id;";
    $conn->query($update);
}
header("Location: adminReport.php");
exit;
