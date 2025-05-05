<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Test Results</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f0f4f9;
    }

    header {
      background: linear-gradient(90deg, #00796b, #004d40);
      color: white;
      padding: 20px;
      text-align: center;
    }

    .stats-section {
      padding: 20px;
    }

    .stats-section h2 {
      color: #004d40;
    }

    .search-bar {
      margin-bottom: 20px;
    }

    .search-bar input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .filter {
      margin-bottom: 20px;
    }

    .filter select {
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    table th, table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }

    table th {
      background-color: #00796b;
      color: white;
    }

    .status-pending {
      color: orange;
      font-weight: bold;
    }

    .status-completed {
      color: green;
      font-weight: bold;
    }

    .date {
      font-size: 0.9em;
      color: #555;
    }

    .action-btn {
      background-color: #00796b;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .action-btn:hover {
      background-color: #005f56;
    }

    .pagination {
      margin-top: 20px;
      text-align: center;
    }

    .pagination button {
      padding: 10px;
      margin: 5px;
      border: none;
      background-color: #00796b;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    .pagination button:hover {
      background-color: #005f56;
    }

    .notifications {
      margin-bottom: 20px;
      padding: 10px;
      background-color: #e0f2f1;
      border-left: 4px solid #004d40;
      font-size: 0.9em;
    }

    .notifications p {
      margin: 0;
    }

    @media (max-width: 768px) {
      table th, table td {
        font-size: 0.9em;
      }

      .action-btn {
        font-size: 0.8em;
        padding: 5px 10px;
      }
    }
  </style>
</head>
<body>

<header>
  <h1>Test Results</h1>
</header>

<div class="stats-section">
  <div class="notifications">
    <p>New test results updated recently!</p>
  </div>

  <div class="search-bar">
    <input type="text" placeholder="Search by patient name or test type...">
  </div>

  <div class="filter">
    <select>
      <option value="all">All Statuses</option>
      <option value="pending">Pending</option>
      <option value="completed">Completed</option>
    </select>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Patient</th>
        <th>Test Type</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>John Doe</td>
        <td>Blood Test</td>
        <td class="status-pending">Pending</td>
        <td class="date">April 10, 2025, 08:15 AM</td>
        <td>
          <button class="action-btn">View Details</button>
          <button class="action-btn">Download</button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>Jane Smith</td>
        <td>Allergy Test</td>
        <td class="status-completed">Completed</td>
        <td class="date">April 9, 2025, 04:30 PM</td>
        <td>
          <button class="action-btn">View Details</button>
          <button class="action-btn">Download</button>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="pagination">
    <button>Previous</button>
    <button>1</button>
    <button>2</button>
    <button>Next</button>
  </div>
</div>

</body>
</html>