<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Schedule Management</title>
  <style>
    /* General Styling */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fb;
      margin: 0;
      padding: 0;
    }
    h2 {
      color: #004d40;
      margin: 20px;
    }
    .filter {
      display: flex;
      justify-content: flex-start;
      margin: 20px;
    }
    .filter input {
      padding: 12px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      width: 250px;
    }
    .summary {
      display: flex;
      justify-content: space-between;
      margin: 20px;
    }
    .summary div {
      background-color: #00796b;
      color: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      flex: 1;
      margin: 0 10px;
      transition: background-color 0.3s ease;
    }
    .summary div:hover {
      background-color: #004d40;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px;
    }
    table th, table td {
      padding: 15px;
      text-align: center;
      border: 1px solid #ddd;
    }
    table th {
      background-color: #00796b;
      color: white;
    }
    .action-buttons button {
      background-color: #00796b;
      color: white;
      padding: 8px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease-in-out;
    }
    .action-buttons button:hover {
      background-color: #005f56;
      transform: scale(1.1);
    }
    #add-slot-btn {
      margin: 20px;
      padding: 10px;
      background-color: #00796b;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    #add-slot-btn:hover {
      background-color: #005f56;
    }
  </style>
</head>
<body>
<?php
  include "../../includes/header.php";

  ?>
  <h2>Doctor Schedule Management</h2>

  <div class="summary">
    <div>
      <h3>Total Doctors</h3>
      <p>5</p>
    </div>
    <div>
      <h3>Total Slots</h3>
      <p>20</p>
    </div>
  </div>

  <div class="filter">
    <input type="search" placeholder="Search Doctor Name...">
  </div>

  <table>
    <thead>
      <tr>
        <th>Doctor Name</th>
        <th>Date</th>
        <th>Time Slot</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="schedule-table">
      <tr>
        <td>Dr. Smith</td>
        <td>2025-04-22</td>
        <td>10:00 AM - 11:00 AM</td>
        <td>Available</td>
        <td class="action-buttons">
          <button class="edit-btn">Edit</button>
          <button class="delete-btn">Delete</button>
        </td>
      </tr>
      <tr>
        <td>Dr. Jones</td>
        <td>2025-04-22</td>
        <td>11:00 AM - 12:00 PM</td>
        <td>Booked</td>
        <td class="action-buttons">
          <button class="edit-btn">Edit</button>
          <button class="delete-btn">Delete</button>
        </td>
      </tr>
    </tbody>
  </table>
  <button id="add-slot-btn">Add Slot</button>

  <script>
    // Add Slot Functionality
    const addSlotButton = document.getElementById('add-slot-btn');
    addSlotButton.addEventListener('click', () => {
      const scheduleTable = document.getElementById('schedule-table');
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td>New Doctor</td>
        <td>2025-04-23</td>
        <td>1:00 PM - 2:00 PM</td>
        <td>Available</td>
        <td class="action-buttons">
          <button class="edit-btn">Edit</button>
          <button class="delete-btn">Delete</button>
        </td>
      `;
      scheduleTable.appendChild(newRow);
      alert('New slot added successfully!');
    });

    // Edit and Delete Slot Functionalities
    document.getElementById('schedule-table').addEventListener('click', (event) => {
      // Edit functionality
      if (event.target.classList.contains('edit-btn')) {
        const row = event.target.closest('tr');
        const cells = row.getElementsByTagName('td');
        const doctorName = prompt('Edit Doctor Name:', cells[0].innerText);
        const date = prompt('Edit Date (YYYY-MM-DD):', cells[1].innerText);
        const timeSlot = prompt('Edit Time Slot (e.g., 1:00 PM - 2:00 PM):', cells[2].innerText);
        const status = prompt('Edit Status (Available/Booked):', cells[3].innerText);

        if (doctorName && date && timeSlot && status) {
          cells[0].innerText = doctorName;
          cells[1].innerText = date;
          cells[2].innerText = timeSlot;
          cells[3].innerText = status;
          alert('Slot updated successfully!');
        }
      }

      // Delete functionality
      if (event.target.classList.contains('delete-btn')) {
        const row = event.target.closest('tr');
        row.remove();
        alert('Slot deleted successfully!');
      }
    });
  </script>
</body>
</html>