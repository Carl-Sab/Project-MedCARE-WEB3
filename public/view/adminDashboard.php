<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
  <style>
    /* Basic styling */
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background-color: #f4f7fc;
      color: #003f7d;
    }

    .header {
      background: linear-gradient(135deg, #0066cc, #4a90e2);
      padding: 20px;
      color: white;
      display: flex;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000; /* Below sidebar */
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
      flex: 1;
    }

    .burger-btn {
      background: none;
      border: none;
      color: white;
      font-size: 24px;
      cursor: pointer;
      z-index: 1002; /* Above header */
    }

    .sidebar {
      width: 250px;
      background-color: #003f7d;
      color: white;
      height: 100vh;
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      transform: translateX(-100%);
      transition: transform 0.3s ease-in-out;
      z-index: 1001; /* Above header */
    }

    .sidebar.open {
      transform: translateX(0);
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px 0;
      border-radius: 5px;
    }

    .sidebar a:hover {
      background-color: #4a90e2;
    }

    .main-content {
      padding: 100px 20px;
      margin-left: 0;
      transition: margin-left 0.3s ease-in-out;
    }

    .main-content.shifted {
      margin-left: 250px;
    }

    .section {
      background: white;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    table th, table td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ddd;
    }

    .button {
      padding: 10px 15px;
      background-color: #0066cc;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .button:hover {
      background-color: #005bb5;
    }

    form {
      margin-bottom: 20px;
    }

    form label {
      display: block;
      margin-bottom: 5px;
    }

    form input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000; /* Below sidebar */
      display: none; /* Hidden by default */
      transition: opacity 0.3s ease-in-out;
    }

    .overlay.visible {
      display: block; /* Shown when sidebar is open */
    }
  </style>
</head>
<body>
  <div class="overlay" id="overlay"></div>

  <div class="sidebar" id="sidebar">
    <a href="#">Manage Doctors</a>
    <a href="#">Job Applications</a>
    <a href="#">Monthly Salary</a>
    <a href="#">Logout</a>
  </div>

  <div class="header">
    <button class="burger-btn" id="burgerButton">☰</button>
    <h1>Admin Dashboard</h1>
  </div>

  <div class="main-content" id="mainContent">
    <!-- Doctor Management Section -->
    <div class="section">
      <h3>Manage Doctors</h3>
      <form id="addDoctorForm">
       
        <label for="doctorName">Doctor Name:</label>
        <input type="text" id="doctorName" placeholder="Enter doctor's name">
        <label for="doctorSpecialty">Specialty:</label>
        <input type="text" id="doctorSpecialty" placeholder="Enter specialty">
        <label for="doctorSalary">Salary:</label>
        <input type="text" id="doctorSalary" placeholder="Enter salary">
        <button type="button" class="button" id="addDoctorButton">Add Doctor</button>
      </form>
      <table id="doctorsTable">
        <thead>
          <tr>
            <th>Profile Picture</th>
            <th>ID</th>
            <th>Doctor Name</th>
            <th>Specialty</th>
            <th>Salary</th>
            <th>Review</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Doctors -->
        </tbody>
      </table>
    </div>

    <!-- Job Applications Section -->
    <div class="section">
      <h3>Job Applications</h3>
      <table>
        <thead>
          <tr>
            <th>Applicant Name</th>
            <th>Position</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="applicationsTableBody">
          <!-- Applications -->
        </tbody>
      </table>
    </div>
  </div>

  <script>
    const burgerButton = document.getElementById('burgerButton');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mainContent = document.getElementById('mainContent');

    // Toggle Sidebar
    burgerButton.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      overlay.classList.toggle('visible');
    });

    // Close Sidebar on Overlay Click
    overlay.addEventListener('click', () => {
      sidebar.classList.remove('open');
      overlay.classList.remove('visible');
    });

    const doctorsTableBody = document.getElementById('doctorsTable').querySelector('tbody');
    const addDoctorForm = document.getElementById('addDoctorForm');

    // Add Doctor Form Submission
    document.getElementById('addDoctorButton').addEventListener('click', () => {
      const profilePic = document.getElementById('profilePicture').value;
      const name = document.getElementById('doctorName').value;
      const specialty = document.getElementById('doctorSpecialty').value;
      const salary = document.getElementById('doctorSalary').value;
      const id = Math.random().toString(36).substring(2, 8).toUpperCase(); // Random ID generator
      const review = '★★★★★';

      if (profilePic && name && specialty && salary) {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td><img src="${profilePic}" alt="Profile Picture" style="border-radius: 50%;"></td>
          <td>${id}</td>
          <td>${name}</td>
          <td>${specialty}</td>
          <td>${salary}</td>
          <td>${review}</td>
          <td><button class="button" onclick="removeDoctor(this)">Remove</button></td>
        `;
        doctorsTableBody.appendChild(row);
        addDoctorForm.reset(); // Clear the form fields
      }
    });

    // Remove Doctor
    function removeDoctor(button) {
      const row = button.parentElement.parentElement;
      doctorsTableBody.removeChild(row);
    }

    // Job Applications Data
    const applications = [
      { name: 'John Doe', position: 'Software Engineer', status: 'Under Review' },
      { name: 'Jane Smith', position: 'UI Designer', status: 'Under Review' },
    ];

    // Populate Job Applications Table
    const applicationsTableBody = document.getElementById('applicationsTableBody');
    applications.forEach((applicant, index) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${applicant.name}</td>
        <td>${applicant.position}</td>
        <td id="status-${index}">${applicant.status}</td>
        <td>
          <button class="button" onclick="acceptApplicant(${index})">Accept</button>
          <button class="button" onclick="declineApplicant(${index})">Decline</button>
        </td>
      `;
      applicationsTableBody.appendChild(row);
    });

    // Accept Applicant
    function acceptApplicant(index) {
      const applicant = applications[index];
      const id = Math.random().toString(36).substring(2, 8).toUpperCase(); // Random ID generator
      const review = '★★★★★';
      const row = document.createElement('tr');
      row.innerHTML = `
        <td><img src="https://via.placeholder.com/50" alt="Profile Picture" style="border-radius: 50%;"></td>
        <td>${id}</td>
        <td>${applicant.name}</td>
        <td>${applicant.position}</td>
        <td>$100,000</td>
        <td>${review}</td>
        <td><button class="button" onclick="removeDoctor(this)">Remove</button></td>
      `;
      doctorsTableBody.appendChild(row);
      document.getElementById(`status-${index}`).textContent = 'Accepted';
    }

    // Decline Applicant
    function declineApplicant(index) {
      document.getElementById(`status-${index}`).textContent = 'Declined';
    }
  </script>
</body>
</html>
