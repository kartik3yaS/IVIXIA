<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goal Profile</title>
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
        if (isset($_GET['goal_id'])) {
            $goal_id = intval($_GET['goal_id']);
            
            $sql = "SELECT * FROM goals WHERE goal_id = $goal_id";
            $result = mysqli_query($conn, $sql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $goal = mysqli_fetch_assoc($result);
                ?>
                <div class="bg-light p-4 mb-4 rounded d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1" style="flex-basis: 70%;">
                        <h2><?php echo htmlspecialchars($goal['goal_title']); ?></h2>
                        <p><?php echo htmlspecialchars($goal['goal_desc']); ?></p>
                    </div>
                    <div class="text-end" style="flex-basis: 30%;">
                        <a href="/GOKRT/List/listGoal.php" class="btn btn-lg btn-primary">Go Back</a>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <a href="/GOKRT/Add/addObjective.php?goal_id=<?php echo $goal_id; ?>" class="btn btn-primary">Add Objective</a>
                    <a href="#" class="btn btn-warning me-2">Share Goal</a>
                    <button class="btn btn-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i> <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
                <h4>Objectives</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Objective Name</th>
                            <th>Objective Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $objectiveSql = "SELECT * FROM objective WHERE goal_id = $goal_id";
                        $objectiveResult = mysqli_query($conn, $objectiveSql);

                        if ($objectiveResult && mysqli_num_rows($objectiveResult) > 0) {
                            $count = 1;
                            while ($objective = mysqli_fetch_assoc($objectiveResult)) {
                                $progress = 65;
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo htmlspecialchars($objective['objective_title']); ?></td>
                                    <td>
                                        <div class="progress" style="margin-right: 20%;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
                                                <?php echo $progress; ?>%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="/GOKRT/View/viewObjective.php?objective_id=<?php echo $objective['objective_id']; ?>" class="btn btn-primary btn-sm">View Objective</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No objectives found for this goal.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<div class='alert alert-danger'>Goal not found.</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>No goal ID specified.</div>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
