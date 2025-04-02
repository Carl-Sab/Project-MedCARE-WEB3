<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Profile</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/Profile.css">
  <style>

    body {
  margin: 0;
  font-family: 'Roboto', sans-serif;
  background-color: #e0f2f1;
  color: #004d40;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  overflow: hidden;
}

.profile-container {
  display: flex;
  background: white;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  border-radius: 12px;
  overflow: hidden;
  width: 80%;
  max-width: 1000px;
}

.profile-picture {
  background: linear-gradient(135deg, #00796b, #004d40);
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.profile-picture img {
  border-radius: 50%;
  width: 150px;
  height: 150px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  margin-bottom: 15px;
}

.profile-picture h2 {
  color: white;
  margin: 10px 0 0;
  font-size: 24px;
}

.details-section {
  flex: 2;
  padding: 20px;
}

.details-section h3 {
  margin: 0 0 15px;
  font-size: 20px;
  color: #00796b;
}

.details-section p {
  margin: 10px 0;
  font-size: 16px;
  color: #333;
}

.details-section strong {
  color: #004d40;
}

.review {
  margin-top: 20px;
  text-align: left;
  font-size: 18px;
}

.review strong {
  font-size: 18px;
  color: #00796b;
}

.back-button {
  margin-top: 20px;
  display: inline-block;
  padding: 10px 15px;
  background-color: #00796b;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.back-button:hover {
  background-color: #00695c;
}

  </style>
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
      <?php include "../..//includes/starsReview.php";?>
      <a class="back-button" href="">Add review</a>
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