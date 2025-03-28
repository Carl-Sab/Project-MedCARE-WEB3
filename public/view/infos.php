<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern User Form</title>
  <style>
    /* Body Styling */
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #1e3a8a, #2563eb); 
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    
    }

    /* Form Container Styling */
    .form-container {
        color: white;
      width: 100%;
      max-width: 400px;
      background-color: rgba(179, 224, 255, 0.3); 
      padding: 20px 25px;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.9);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    h1 {
      text-align: center;
      color: white;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      font-weight: bold;
      color: white;
    }

    input, select, textarea {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 14px;
      width: 100%;
      background: #f9f9f9;
      box-sizing: border-box;
    }

    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: #2563eb;
      box-shadow: 0 0 5px rgba(37, 99, 235, 0.5);
    }

    textarea {
      resize: none;
      height: 80px;
    }

    button {
      padding: 12px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, #1e3a8a, #2563eb); 
      color: white;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    button:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
    }

    .file-upload {
      display: flex;
      align-items: center;
      gap: 10px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .file-upload input[type="file"] {
      display: none;
    }

    .file-upload label {
      padding: 8px 12px;
      background: linear-gradient(135deg, #1e3a8a, #2563eb); 
      color: white;
      border-radius: 10px;
      cursor: pointer;
    }

    .file-upload label:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
    }

    .preview {
      font-size: 12px;
      color: white;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>User Information</h1>
    <form id="user-form">
      <label for="dob">Date of Birth</label>
      <input type="date" id="dob" name="dob" required>
      
      <label for="blood-type">Blood Type</label>
      <select id="blood-type" name="blood-type" required>
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

      <label for="health-condition">Health Condition</label>
      <textarea id="health-condition" name="health-condition" placeholder="Enter allergies, diseases, etc." required></textarea>

      <label for="profile-pic">Profile Picture</label>
      <div class="file-upload">
        <label for="profile-pic">Upload File</label>
        <input type="file" id="profile-pic" name="profile-pic" accept="image/*">
        <span class="preview" id="file-preview">No file chosen</span>
      </div>

      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
    const fileInput = document.getElementById('profile-pic');
    const filePreview = document.getElementById('file-preview');

    fileInput.addEventListener('change', function() {
      const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
      filePreview.textContent = fileName;
    });

    document.getElementById('user-form').addEventListener('submit', function(event) {
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

      alert("Form submitted successfully!");
    });
  </script>
</body>
</html>