<?php
include "../../includes/connection.php";

if (isset($_POST['id_user'],$_POST['role'])) {
    $id_user = $_POST['id_user'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET role = '$role' WHERE id_user = $id_user";
    $conn->query($sql);
    header("Location: adminManageUser.php");
    exit();
}
$conn->close();
?>
