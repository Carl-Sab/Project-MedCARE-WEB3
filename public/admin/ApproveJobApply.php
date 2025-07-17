<?php
<<<<<<< Updated upstream

include "../../includes/connection.php";
=======
include "../../includes/security.php";
include "../../includes/connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $jobApplyId = intval($_POST['id']);

    // Get application info
    $sql = "SELECT * FROM job_apply WHERE id_job_apply = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $jobApplyId);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();
    $stmt->close();

    if ($application) {
        // Insert into doctor table
        $insert = "INSERT INTO doctor (id_doctor, speciality, consultation_amount, booking_amount)
                   VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("isii", $application['id_client'], $application['speciality'], $application['chat_sessions_price'], $application['booking_price']);

        if ($stmt->execute()) {
            $stmt->close();

            $client_id = $application['id_client'];

            // Update job_apply status
            $update = $conn->prepare("UPDATE job_apply SET stats='approved' WHERE id_job_apply = ?");
            if (!$update) {
                die("Prepare failed: " . $conn->error);
            }
            $update->bind_param("i", $jobApplyId);
            $update->execute();
            $update->close();

            // Delete client entry
            $delete = $conn->prepare("DELETE FROM client WHERE id_client = ?");
            if (!$delete) {
                die("Prepare failed: " . $conn->error);
            }
            $delete->bind_param("i", $client_id);
            $delete->execute();
            $delete->close();

            // Update user role
            $update = $conn->prepare("UPDATE users SET role = 'doctor' WHERE id_user = ?");
            if (!$update) {
                die("Prepare failed: " . $conn->error);
            }
            $update->bind_param("i", $client_id);
            $update->execute();
            $update->close();

            header("Location: adminJobApply.php?approved=1");
            exit();
        } else {
            echo "Error inserting into doctor table: " . $stmt->error;
            $stmt->close();
        }
    } else {
        echo "Application not found.";
    }
} else {
    echo "Invalid request.";
}
?>
>>>>>>> Stashed changes
