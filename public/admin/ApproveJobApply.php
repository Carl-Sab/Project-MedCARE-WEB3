<?php
include "../../includes/connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $jobApplyId = intval($_POST['id']);

   
    $sql = "SELECT * FROM job_apply WHERE id_job_apply = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $jobApplyId);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();
    $stmt->close();
    
    if ($application) {
      
        $insert = "INSERT INTO doctor (id_doctor, speciality, shifts, consultation_amount, booking_amount)
                   VALUES (?, ?, 'AM', ?, ?)";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param("isii", $application['id_client'], $application['title'], $application['chat_sessions_price'], $application['booking_price']);
        $client_id=$application['id_client'];

        if ($stmt->execute()) {
            $update = $conn->prepare("UPDATE job_apply SET stats='approved' WHERE id_job_apply = ?");
            $update->bind_param("i", $jobApplyId);
            $update->execute();
            $update->close();

            $delete = $conn->prepare("DELETE FROM client WHERE id_client = ?");
            $delete->bind_param("i", $client_id);
            $delete->execute();
            $delete->close();

       
            $update = $conn->prepare("UPDATE users SET role = 'doctor' WHERE id_user = ?");
            $update->bind_param("i", $application['id_client']);
            $update->execute();
            $update->close();

            header("Location: adminJobApply.php?approved=1");
            exit();
        } else {
            echo "Error adding to doctor table: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Application not found.";
    }
} else {
    echo "Invalid request.";
}
?>
