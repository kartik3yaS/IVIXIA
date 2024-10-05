<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Objective</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php
        if (isset($_GET['goal_id'])) {
            $goal_id = intval($_GET['goal_id']);
            $goal_name = '';

            $goalSql = "SELECT goal_title FROM goals WHERE goal_id = $goal_id";
            $goalResult = mysqli_query($conn, $goalSql);
            
            if ($goalResult && mysqli_num_rows($goalResult) > 0) {
                $goal = mysqli_fetch_assoc($goalResult);
                $goal_name = htmlspecialchars($goal['goal_title']);
            }
        ?>

        <h2 class="mb-4">Add Objective For Goal: <?php echo $goal_name ? $goal_name : '[Goal Not Found]'; ?></h2>

        <form action="" method="post">
            <div class="mb-3">
                <label for="objectiveName" class="form-label">Objective Name</label>
                <input type="text" class="form-control" name="objective_title" id="objectiveName" placeholder="Enter objective name" required>
            </div>
            <div class="mb-3">
                <label for="objectiveDescription" class="form-label">Objective Description</label>
                <textarea class="form-control" name="objective_desc" id="objectiveDescription" rows="3" placeholder="Enter objective description" required></textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary" name="addAndStay">Add & Stay</button>
                <button type="submit" class="btn btn-primary" name="addAndContinue">Add & Continue to KR</button>
                <button type="button" class="btn btn-warning" id="skipForNow">Skip For Now</button>
            </div>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $objective_title = $_POST['objective_title'];
            $objective_desc = $_POST['objective_desc'];

            $objectiveSql = "INSERT INTO objective (goal_id, objective_title, objective_desc) VALUES ('$goal_id', '$objective_title', '$objective_desc')";
            if (mysqli_query($conn, $objectiveSql)) {
                $objective_id = mysqli_insert_id($conn);

                if (isset($_POST['addAndContinue'])) {
                    header("Location: /GOKRT/Add/addKR.php?goal_id=$goal_id&objective_id=$objective_id");
                    exit();
                } elseif (isset($_POST['addAndStay'])) {
                    header("Location: /GOKRT/View/viewGoal.php?goal_id=$goal_id");
                    exit();
                } else {
                    echo "<div class='alert alert-success mt-3'>Objective added successfully!</div>";
                }
            } else {
                echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
            }
        }
        ?>
        <?php
        } else {
            echo "<div class='alert alert-warning'>No goal ID specified.</div>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
