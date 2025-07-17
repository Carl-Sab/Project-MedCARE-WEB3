<?php
<<<<<<< Updated upstream
include "../../includes/connection.php";
=======
include "../../includes/security.php";
include "../../includes/connection.php";

>>>>>>> Stashed changes

if (isset($_POST['id_emergency'])) {
    $id = intval($_POST['id_emergency']);
    $update = "UPDATE emergency SET stats = 'Approved' WHERE id_emergency = $id;";
    if ($conn->query($update)) {
        header("Location: adminEmergency.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "id_emergency not set.";
}

