<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Profile</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/Profile.css">
</head>
<body>
  <div class="profile-container">
    <div class="profile-picture">
        <img src="../images/user.png" alt="User Profile Picture">
      <h2 id="doctorName">Dr. John Doe</h2>
    </div>
    <div class="details-section">
      <h3>Doctor Details</h3>
      <p><strong>ID:</strong> <span id="doctorID">D001</span></p>
      <p><strong>Email:</strong> <span id="doctorEmail">john.doe@example.com</span></p>
      <p><strong>Phone:</strong> <span id="doctorPhone">+123 456 7890</span></p>
      <p><strong>Specialty:</strong> <span id="doctorSpecialty">Cardiology</span></p>
      <p><strong>Salary:</strong> <span id="doctorSalary">$100,000</span></p>
      <div class="review">
        <strong>Review:</strong>
        <p>★★★★★</p>
      </div>
      <a class="back-button" href="/index.php">Add review</a>
    </div>
  </div>

  <script>
    // Example data for demonstration (replace with dynamic data in your implementation)
    const doctorData = {
      id: "D001",
      name: "Dr. John Doe",
      email: "john.doe@example.com",
      phone: "+123 456 7890",
      specialty: "Cardiology",
      salary: "$100,000",
      pictureUrl: "https://via.placeholder.com/150"
    };

    // Populate the profile page with doctor data
    document.getElementById('doctorImage').src = doctorData.pictureUrl;
    document.getElementById('doctorName').textContent = doctorData.name;
    document.getElementById('doctorID').textContent = doctorData.id;
    document.getElementById('doctorEmail').textContent = doctorData.email;
    document.getElementById('doctorPhone').textContent = doctorData.phone;
    document.getElementById('doctorSpecialty').textContent = doctorData.specialty;
    document.getElementById('doctorSalary').textContent = doctorData.salary;

  </script>
</body>
</html>