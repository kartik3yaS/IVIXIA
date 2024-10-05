<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Goal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
        }
        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add a New Goal</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $sql = "INSERT INTO goals (goal_title, goal_desc) VALUES ('$title', '$description')";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success'>Goal added successfully!</div>";
            header("Location: /GOKRT/List/listGoal.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }
    }
    ?>

    <form action="" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Goal</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
