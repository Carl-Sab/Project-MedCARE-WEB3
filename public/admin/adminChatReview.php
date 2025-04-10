<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Chat Reviews</title>
  <style>
    .stats-section {
      padding: 20px;
    }

    .stats-section h2 {
      color: #004d40;
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

    .status-readed {
      color: green;
      font-weight: bold;
    }

    .date {
      font-size: 0.9em;
      color: #555;
    }

    .mark-read-btn {
      background-color: #00796b;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .mark-read-btn:hover {
      background-color: #005f56;
    }
  </style>
</head>
<body>

<?php
include "../../includes/header.php";
?>

<div class="stats-section">
  <h2>Chat Reviews</h2>
  <br>
 
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Review Content</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="status-">
                    
                    </td>
                    <td class="date"></td>
                    <td>
                      <form method="POST" action="markRead.php">
                        <input type="hidden" name="id_review" value="">
                        <button type="submit" class="mark-read-btn">Mark as Read</button>
                      </form>
                    </td>
                  </tr>
             
            </tbody>
          </table>
  
</div>

</body>
</html>

