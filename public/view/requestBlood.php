
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/requestBlood.css">
</head>
<body>
    
    <?php 
session_start();
include "../../includes/header.php";
include "../../includes/connection.php";
$id_client=$_SESSION['id_user'];
$query="SELECT blood_type from client where id_client=?";
$stmt=$conn->prepare($query);
$stmt->bind_param("i",$id_client);
$stmt->execute();
$result=$stmt->get_result();
$client = $result->fetch_assoc();
if(!$client){
    echo "Client not found.";
    exit;
}
$bloodType=$client["blood_type"];
$queryDonors = "
    SELECT u.id_user, u.user_name, u.email, u.tel
    FROM users u
    JOIN client c ON u.id_user = c.id_client
    WHERE c.blood_type = ? AND c.id_client != ?
";
$stmtDonors = $conn->prepare($queryDonors);
$stmtDonors->bind_param("si", $bloodType, $id_client);
$stmtDonors->execute();
$resultDonors = $stmtDonors->get_result();
if(!$resultDonors){
    echo "No donors found";
    exit();
}else{
$donorsArray=$resultDonors->fetch_assoc();
    ?>
    <table>
        <thead>
            <th>Donor_ID</th>
            <th>Donor_Name</th>
            <th>Donor_Email</th>
            <th>Donor_TEL</th>
        </thead>
    <tbody>
        <?php while ($donor = $resultDonors->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($donor["id_user"]) ?></td>
                <td><?= htmlspecialchars($donor["user_name"]) ?></td>
                <td><?= htmlspecialchars($donor["email"]) ?></td>
                <td><?= htmlspecialchars($donor["tel"]) ?></td>
            </tr>
        <?php } ?>
    </tbody>
    </table>
    <?php
}

?>

</body>
</html>