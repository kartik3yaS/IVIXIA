<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Key Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .goal-title {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Add a New Key Result</h2>

    <?php
    if (isset($_GET['goal_id']) && isset($_GET['objective_id'])) {
        $goal_id = intval($_GET['goal_id']);
        $objective_id = intval($_GET['objective_id']);

        $objectiveSql = "
            SELECT o.objective_title, g.goal_title 
            FROM objective AS o 
            JOIN goals AS g ON o.goal_id = g.goal_id 
            WHERE o.objective_id = $objective_id AND g.goal_id = $goal_id
        ";
        $objectiveResult = mysqli_query($conn, $objectiveSql);
        
        if ($objectiveResult && mysqli_num_rows($objectiveResult) > 0) {
            $objective = mysqli_fetch_assoc($objectiveResult);
            ?>
            <div class="mb-4">
                <strong>Add Key Result for Objective:</strong> 
                <span class="goal-title"><?php echo htmlspecialchars($objective['objective_title']); ?></span>
            </div>

            <form action="" method="post" class="p-4 shadow-lg rounded">
                <div class="mb-3">
                    <label for="kr_title" class="form-label">Key Result Title:</label>
                    <input type="text" class="form-control" name="kr_title" id="kr_title" required>
                </div>
                <div class="mb-3">
                    <label for="kr_desc" class="form-label">Key Result Description:</label>
                    <textarea class="form-control" name="kr_desc" id="kr_desc" rows="4" required></textarea>
                </div>

                <input type="hidden" name="objective_id" value="<?php echo $objective_id; ?>">
                <input type="hidden" name="goal_id" value="<?php echo $goal_id; ?>">
                <button type="submit" class="btn btn-primary w-100">Add Key Result</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $objective_id = $_POST['objective_id'];
                $goal_id = $_POST['goal_id'];
                $kr_title = $_POST['kr_title'];
                $kr_desc = $_POST['kr_desc'];

                $krSql = "INSERT INTO kr (objective_id, kr_title, kr_desc) VALUES ('$objective_id', '$kr_title', '$kr_desc')";

                if (mysqli_query($conn, $krSql)) {
                    header("Location: /GOKRT/View/viewObjective.php?goal_id=$goal_id&objective_id=$objective_id");
                    exit();
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
                }
            }
        } else {
            echo "<div class='alert alert-danger'>Objective not found.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>No goal or objective ID specified.</div>";
    }
    ?>

    <a href="/GOKRT/List/listObjective.php" class="btn btn-info mt-3">View Objectives</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
