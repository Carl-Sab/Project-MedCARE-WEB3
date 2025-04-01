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
        <img src="../images/user.png" alt="User Profile Picture" id="doctorImage">
      <h2 id="doctorName">Dr. John Doe</h2>
    </div>
    <div class="details-section">
      <h3>Doctor Details</h3>
      <p><strong>ID:</strong> <span id="doctorID">D001</span></p>
      <p><strong>Email:</strong> <span id="doctorEmail">john.doe@example.com</span></p>
      <p><strong>Phone:</strong> <span id="doctorPhone">+123 456 7890</span></p>
      <p><strong>Specialty:</strong> <span id="doctorSpecialty">Cardiology</span></p>
      <p><strong>Salary:</strong> <span id="doctorSalary">$100,000</span></p>
      
      <!-- Star Rating Section -->
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
    // Example data for demonstration (replace with dynamic data in your implementation)
    const doctorData = {
      id: "D001",
      name: "Dr. John Doe",
      email: "john.doe@example.com",
      phone: "+123 456 7890",
      specialty: "Cardiology",
      salary: "$100,000",
      // pictureUrl: "https://via.placeholder.com/150"
    };

    // Populate the profile page with doctor data

    document.getElementById('doctorName').textContent = doctorData.name;
    document.getElementById('doctorID').textContent = doctorData.id;
    document.getElementById('doctorEmail').textContent = doctorData.email;
    document.getElementById('doctorPhone').textContent = doctorData.phone;
    document.getElementById('doctorSpecialty').textContent = doctorData.specialty;
    document.getElementById('doctorSalary').textContent = doctorData.salary;

    // Star Rating Script
    const stars = document.querySelectorAll('.star');
    const ratingText = document.querySelector('#rating');
    
    stars.forEach(star => {
      star.addEventListener('click', () => {
        const ratingValue = star.dataset.value;
        ratingText.textContent = ratingValue;

        // Fill all stars up to the clicked one
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

        // Highlight stars up to the hovered one
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

        // Restore to the current rating when mouse moves out
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
