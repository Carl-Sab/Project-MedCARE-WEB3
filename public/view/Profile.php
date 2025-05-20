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
        <img src="../images/user.png" alt="User Profile Picture" id="doctorImage">
      <h2 id="doctorName">Dr. John Doe</h2>
    </div>
    <div class="details-section">
      <h3>Doctor Details</h3>
 
      <p><strong>Email:</strong> <span id="doctorEmail">john.doe@example.com</span></p>
      <p><strong>Phone:</strong> <span id="doctorPhone">+123 456 7890</span></p>
      <p><strong>Specialty:</strong> <span id="doctorSpecialty">Cardiology</span></p>

      
      <div class="star-rating">
        <span class="star" data-value="1">★</span>
        <span class="star" data-value="2">★</span>
        <span class="star" data-value="3">★</span>
        <span class="star" data-value="4">★</span>
        <span class="star" data-value="5">★</span>
      </div>
      <p id="rating-text">You have rated this: <span id="rating">0</span> stars</p>
      
      <a class="back-button" href="">Add review</a>
    </div>
  </div>
  
  <script>
    const doctorData = {
      id: "D001",
      name: "Dr. John Doe",
      email: "john.doe@example.com",
      phone: "+123 456 7890",
      specialty: "Cardiology",
      salary: "$100,000",
      // pictureUrl: "https://via.placeholder.com/150"
    };


    document.getElementById('doctorName').textContent = doctorData.name;
    document.getElementById('doctorID').textContent = doctorData.id;
    document.getElementById('doctorEmail').textContent = doctorData.email;
    document.getElementById('doctorPhone').textContent = doctorData.phone;
    document.getElementById('doctorSpecialty').textContent = doctorData.specialty;
    document.getElementById('doctorSalary').textContent = doctorData.salary;

    const stars = document.querySelectorAll('.star');
    const ratingText = document.querySelector('#rating');
    
    stars.forEach(star => {
      star.addEventListener('click', () => {
        const ratingValue = star.dataset.value;
        ratingText.textContent = ratingValue;

        stars.forEach(s => {
          if (s.dataset.value <= ratingValue) {
            s.classList.add('filled');
          } else {
            s.classList.remove('filled');
          }
        });
      });

      star.addEventListener('mouseover', () => {
        const hoverValue = star.dataset.value;

        stars.forEach(s => {
          if (s.dataset.value <= hoverValue) {
            s.classList.add('filled');
          } else {
            s.classList.remove('filled');
          }
        });
      });

      star.addEventListener('mouseout', () => {
        const currentRating = ratingText.textContent;

        stars.forEach(s => {
          if (s.dataset.value <= currentRating) {
            s.classList.add('filled');
          } else {
            s.classList.remove('filled');
          }
        });
      });
    });
  </script>
</body>
</html>
