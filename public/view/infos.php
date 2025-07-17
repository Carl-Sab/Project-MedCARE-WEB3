<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern User Form</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <link rel="stylesheet" href="../css/infos.css">
</head>
<?php

include "../../includes/security.php";

include "../../includes/connection.php";

$id = $_SESSION["id_user"];

$msg = "";
if (isset($_POST['dob'], $_POST['adress'], $_POST['blood_type'], $_POST['condition'])) {
    $dob = $_POST['dob'];
    $adress = $_POST['adress'];
    $blood_type = $_POST['blood_type'];
    $condition = $_POST['condition'];
    $id = $_SESSION["id_user"];

    $file_uploaded = false;
    $file_name = 'default_profile_pic.jpg';

    if (isset($_FILES["profile-pic"]) && $_FILES["profile-pic"]["error"] === 0) {
        $format = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'tif', 'heif', 'heic', 'ico', 'svg'];
        $file_extension = strtolower(pathinfo($_FILES['profile-pic']['name'], PATHINFO_EXTENSION));

        if (in_array($file_extension, $format)) {
            $upload_dir = '../images/uploads/';
            $file_name = basename($_FILES['profile-pic']['name']);
            $upload_file_path = $upload_dir . $file_name;

            if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
                $msg = "Upload directory is not writable.";
            } else {
                if (move_uploaded_file($_FILES['profile-pic']['tmp_name'], $upload_file_path)) {
                    $file_uploaded = true;
                } else {
                    $msg = "Error while uploading the file.";
                }
            }
        } else {
            $msg = "Invalid file format.";
        }
    }

    if ($file_uploaded) {
        $update = "UPDATE users SET `PPicture` = '$file_name', `date_of_birth` = '$dob', `adress` = '$adress' WHERE `id_user` = '$id';";
    } else {
        $update = "UPDATE users SET `date_of_birth` = '$dob', `adress` = '$adress' WHERE `id_user` = '$id';";
    }

    if ($conn->query($update) === TRUE) {
      $insert = "INSERT INTO client (id_client, blood_type, health_condition) VALUES ($id, '$blood_type', '$condition')";
        
        if ($conn->query($insert) === TRUE) {
          header("location:homepage.php");
        } else {
            $msg = "Error while inserting client data: " . $conn->error;
        }
    } else {
        $msg = "Error while updating user data: " . $conn->error;
    }
}

?>
<body>
<div class="background">
      <div class="glow"></div>
    </div>
  <div class="form-container">
    <h1>User Information</h1>
    <form action="infos.php" method="POST" id="user-form" enctype="multipart/form-data">
      <label for="dob">Date of Birth</label>
      <input type="date" id="dob" name="dob" required>

      <label for="adress">Address</label>
      <input type="text" placeholder="Address" name="adress" required>
      
      <label for="blood-type">Blood Type</label>
      <select id="blood-type" name="blood_type" required>
        <option value="" disabled selected>Select</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
      </select>

      <label for="condition">Health Condition</label>
      <textarea id="health-condition" name="condition" placeholder="Enter allergies, diseases, etc." required></textarea>

      <label for="profile-pic">Profile Picture</label>
      <div class="file-upload">
        <label for="profile-pic">Upload File</label>
        <input type="file" id="profile-pic" name="profile-pic" accept="image/*">
        <span class="preview" id="file-preview">No file chosen</span>
      </div>
      <p><?php echo(isset($msg)?$msg:"");?></p>

      <button type="submit" id="Submit">Submit</button>
    </form>
  </div>
  <script>
    const fileInput = document.getElementById('profile-pic');
    const filePreview = document.getElementById('file-preview');

    fileInput.addEventListener('change', function() {
      const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
      filePreview.textContent = fileName;
    });

    document.querySelector('button').addEventListener('click', function(event) {
      event.preventDefault();
      
      const dob = document.getElementById('dob').value;
      const bloodType = document.getElementById('blood-type').value;
      const healthCondition = document.getElementById('health-condition').value;
      const profilePic = document.getElementById('profile-pic').files[0];

      console.log("Date of Birth:", dob);
      console.log("Blood Type:", bloodType);
      console.log("Health Condition:", healthCondition);
      if (profilePic) {
        console.log("Profile Picture:", profilePic.name);
      }

      document.querySelector('#user-form').submit();
    });
  </script>
</body>
</html>