<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List Goals</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
      body {
          background-color: #f8f9fa;
      }
      .container {
          margin-top: 50px;
          max-width: 800px;
          background-color: #fff;
          padding: 20px;
          border-radius: 8px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      h2 {
          color: #333;
      }
      .no-goals {
          text-align: center;
          margin-top: 20px;
          font-size: 1.2rem;
          color: #dc3545;
      }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
      <h2>All of your Goals</h2>
      <a href="/GOKRT/Add/addGoal.php" class="btn btn-success">Add New Goal</a>
    </div>
    <table class="table table-hover mt-4">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Goal Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM goals";
        $result = mysqli_query($conn, $sql);
        $serial_number = 1;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $serial_number++ . "</td>
                        <td>" . htmlspecialchars($row['goal_title']) . "</td>
                        <td>
                          <a href='/GOKRT/View/viewGoal.php?goal_id=" . $row['goal_id'] . "' class='btn btn-primary btn-sm'>View Goal</a>
                          <a href='#' class='btn btn-warning btn-sm'>Share Goal</a>
                          <a href='delete-goal.php?id=" . $row['goal_id'] . "' class='btn btn-danger btn-sm'>
                            <i class='bi bi-trash-fill'></i>
                          </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3' class='no-goals'>No goals found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>