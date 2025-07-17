<?php
<<<<<<< Updated upstream

include "../../includes/connection.php";
=======
include "../../includes/security.php";
include "../../includes/connection.php";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id_job_apply = intval($_POST["id"]);

    $update = $conn->prepare("UPDATE job_apply SET stats='rejected' WHERE id_job_apply = ?");
    $update->bind_param("i", $id_job_apply);
    $update->execute();
    $update->close();

    header("Location: adminJobApply.php?");
    exit();
} else {
    echo "Invalid request.";
}
>>>>>>> Stashed changes
