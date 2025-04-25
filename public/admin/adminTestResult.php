<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Results Management</title>
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
    #add-result-btn {
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
    #add-result-btn:hover {
      background-color: #005f56;
    }
  </style>
</head>
<body>
  <h2>Test Results Management</h2>

  <div class="summary">
    <div>
      <h3>Total Tests</h3>
      <p>50</p>
    </div>
    <div>
      <h3>Pending Results</h3>
      <p>10</p>
    </div>
    <div>
      <h3>Completed Results</h3>
      <p>40</p>
    </div>
  </div>

  <div class="filter">
    <input type="search" placeholder="Search by Patient or Test Name...">
  </div>

  <table>
    <thead>
      <tr>
        <th>Patient Name</th>
        <th>Test Name</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="results-table">
      <tr>
        <td>John Doe</td>
        <td>Blood Test</td>
        <td>2025-04-21</td>
        <td>Completed</td>
        <td class="action-buttons">
          <button class="view-btn">View</button>
          <button class="edit-btn">Edit</button>
        </td>
      </tr>
      <tr>
        <td>Jane Smith</td>
        <td>X-Ray</td>
        <td>2025-04-20</td>
        <td>Pending</td>
        <td class="action-buttons">
          <button class="view-btn">View</button>
          <button class="edit-btn">Edit</button>
        </td>
      </tr>
    </tbody>
  </table>
  <button id="add-result-btn">Add New Result</button>

  <script>
    // Add Test Result Functionality
    const addResultButton = document.getElementById('add-result-btn');
    addResultButton.addEventListener('click', () => {
      const resultsTable = document.getElementById('results-table');
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td>New Patient</td>
        <td>New Test</td>
        <td>2025-04-22</td>
        <td>Pending</td>
        <td class="action-buttons">
          <button class="view-btn">View</button>
          <button class="edit-btn">Edit</button>
        </td>
      `;
      resultsTable.appendChild(newRow);
      alert('New test result added!');
    });

    // Edit and View Buttons
    document.getElementById('results-table').addEventListener('click', (event) => {
      // View functionality
      if (event.target.classList.contains('view-btn')) {
        alert('Viewing test result details!');
        // Add your logic for displaying details
      }
      // Edit functionality
      if (event.target.classList.contains('edit-btn')) {
        const row = event.target.closest('tr');
        const cells = row.getElementsByTagName('td');
        const patientName = prompt('Edit Patient Name:', cells[0].innerText);
        const testName = prompt('Edit Test Name:', cells[1].innerText);
        const date = prompt('Edit Date (YYYY-MM-DD):', cells[2].innerText);
        const status = prompt('Edit Status (Pending/Completed):', cells[3].innerText);

        if (patientName && testName && date && status) {
          cells[0].innerText = patientName;
          cells[1].innerText = testName;
          cells[2].innerText = date;
          cells[3].innerText = status;
          alert('Test result updated successfully!');
        }
      }
    });
  </script>
</body>
</html>