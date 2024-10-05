<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Result Profile</title>
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <?php
        if (isset($_GET['kr_id'])) {
            $kr_id = intval($_GET['kr_id']);

            $krSql = "
                SELECT kr.kr_id, kr.kr_desc, kr.kr_title, kr.objective_id, o.objective_title, o.goal_id
                FROM kr 
                JOIN objective AS o ON kr.objective_id = o.objective_id 
                WHERE kr.kr_id = $kr_id
            ";
            $result = mysqli_query($conn, $krSql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $kr = mysqli_fetch_assoc($result);
                ?>
                <div class="bg-light p-4 mb-4 rounded d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1" style="flex-basis: 70%;">
                        <h2><?php echo htmlspecialchars($kr['kr_title']); ?></h2>
                        <p><?php echo htmlspecialchars($kr['kr_desc']); ?></p>
                    </div>
                    <div class="text-end" style="flex-basis: 30%;">
                        <a href="/GOKRT/View/viewObjective.php" class="btn btn-lg btn-primary">Go Back</a>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <a href="/GOKRT/Add/addTask.php?goal_id=<?php echo $kr['goal_id']; ?>&objective_id=<?php echo $kr['objective_id']; ?>&kr_id=<?php echo $kr_id; ?>" class="btn btn-success me-2">Add Task</a>
                    <button class="btn btn-warning me-2">Share Key Result</button>
                    <button class="btn btn-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i> <i class="bi bi-trash-fill"></i>
                    </button>
                </div>

                <h4>Tasks</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Task Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $taskSql = "SELECT * FROM task WHERE kr_id = $kr_id";
                        $taskResult = mysqli_query($conn, $taskSql);

                        if ($taskResult && mysqli_num_rows($taskResult) > 0) {
                            $count = 1;
                            while ($task = mysqli_fetch_assoc($taskResult)) {
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo htmlspecialchars($task['task_desc']); ?></td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No tasks found for this key result.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<div class='alert alert-danger'>Key Result not found.</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>No Key Result ID specified.</div>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
