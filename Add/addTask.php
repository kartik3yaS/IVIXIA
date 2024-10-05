<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 900px;
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
    if (isset($_GET['kr_id']) && isset($_GET['goal_id']) && isset($_GET['objective_id'])) {
        $kr_id = intval($_GET['kr_id']);
        $goal_id = intval($_GET['goal_id']);
        $objective_id = intval($_GET['objective_id']);

        $krSql = "SELECT kr.kr_desc FROM kr WHERE kr.kr_id = $kr_id";
        $krResult = mysqli_query($conn, $krSql);
        $kr_desc = '';

        if ($krResult && mysqli_num_rows($krResult) > 0) {
            $kr = mysqli_fetch_assoc($krResult);
            $kr_desc = htmlspecialchars($kr['kr_desc']);
        }
    ?>

    <h2 class="mb-4">Add a New Task for Key Result: <?php echo $kr_desc ? $kr_desc : '[Key Result Not Found]'; ?></h2>

    <form action="" method="post">
        <div class="mb-3">
            <label for="task_desc" class="form-label">Task Description:</label>
            <textarea class="form-control" name="task_desc" id="task_desc" rows="4" required></textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary" name="addAndStay">Add & Stay</button>
            <button type="submit" class="btn btn-primary" name="addAndContinue">Add & Continue to View KR</button>
            <button type="button" class="btn btn-warning" id="skipForNow" name="skipForNow">Skip For Now</button>
        </div>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $task_desc = $_POST['task_desc'];

        $taskSql = "INSERT INTO task (kr_id, task_desc) VALUES ('$kr_id', '$task_desc')";
        if (mysqli_query($conn, $taskSql)) {
            $task_id = mysqli_insert_id($conn);
            if (isset($_POST['addAndContinue'])) {
                header("Location: /GOKRT/View/viewKR.php?kr_id=$kr_id");
                exit();
            } elseif (isset($_POST['addAndStay'])) {
                echo "<div class='alert alert-success mt-3'>Task added successfully! You can add another task below.</div>";
            } elseif(isset($_POST['skipForNow'])) {
                header("Location: /GOKRT/View/viewKR.php?kr_id=$kr_id");
                exit();
            }
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>

    <?php
    } else {
        echo "<div class='alert alert-warning'>No Key Result ID specified.</div>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
