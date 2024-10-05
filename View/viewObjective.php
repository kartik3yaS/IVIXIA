<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objective Profile</title>
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
        if (isset($_GET['objective_id'])) {
            $objective_id = intval($_GET['objective_id']);
            
            $objectiveSql = "
                SELECT o.objective_title, o.objective_desc, g.goal_id, g.goal_title 
                FROM objective AS o 
                JOIN goals AS g ON o.goal_id = g.goal_id 
                WHERE o.objective_id = $objective_id
            ";
            $result = mysqli_query($conn, $objectiveSql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $objective = mysqli_fetch_assoc($result);
                ?>
                <div class="bg-light p-4 mb-4 rounded d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1" style="flex-basis: 70%;">
                        <h2><?php echo htmlspecialchars($objective['objective_title']); ?></h2>
                        <p><?php echo htmlspecialchars($objective['objective_desc']); ?></p>
                    </div>
                    <div class="text-end" style="flex-basis: 30%;">
                        <a href="/GOKRT/List/listGoal.php" class="btn btn-lg btn-primary">Go Back</a>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <a href="/GOKRT/Add/addKR.php?goal_id=<?php echo $objective['goal_id']; ?>&objective_id=<?php echo $objective_id; ?>" class="btn btn-success me-2">Add Key Result</a>
                    <button class="btn btn-warning me-2">Share Objective</button>
                    <button class="btn btn-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i> <i class="bi bi-trash-fill"></i>
                    </button>
                </div>

                <h4>Key Results</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Key Result Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $krSql = "SELECT * FROM kr WHERE objective_id = $objective_id";
                        $krResult = mysqli_query($conn, $krSql);

                        if ($krResult && mysqli_num_rows($krResult) > 0) {
                            $count = 1;
                            while ($kr = mysqli_fetch_assoc($krResult)) {
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo htmlspecialchars($kr['kr_desc']); ?></td>
                                    <td>
                                        <a href="/GOKRT/View/viewKR.php?kr_id=<?php echo $kr['kr_id']; ?>" class="btn btn-primary btn-sm">View Key Result</a>
                                        <!-- <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                        <button class="btn btn-danger btn-sm">Delete</button> -->
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No key results found for this objective.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<div class='alert alert-danger'>Objective not found.</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>No objective ID specified.</div>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
