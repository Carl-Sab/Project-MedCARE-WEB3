<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Chat Reviews</title>
  <link rel="stylesheet" href="../css/adminChatReview.css">
</head>
<body>

<?php
include "../../includes/header.php";


include "../../includes/connection.php";
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

