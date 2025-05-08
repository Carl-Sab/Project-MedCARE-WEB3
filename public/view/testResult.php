<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Test Results</title>
  <link rel="stylesheet" href="../css/testResult.css">
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