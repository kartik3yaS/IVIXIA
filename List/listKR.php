<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Key Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .btn-add {
            display: block;
            margin: 20px auto;
        }
        .objective-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            margin-top: 10px;
        }
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .no-results {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2rem;
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Key Results List</h2>

    <?php
    $sql = "SELECT kr.kr_id, kr.kr_desc, obj.objective_title 
            FROM kr 
            JOIN objective AS obj ON kr.objective_id = obj.objective_id 
            ORDER BY obj.objective_title";
    $result = mysqli_query($conn, $sql);
    $current_objective = '';
    $sno = 1;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($current_objective != $row['objective_title']) {
                if ($current_objective != '') {
                    echo "</tbody></table>";
                }
                $current_objective = $row['objective_title'];
                echo "<div class='objective-header'>$sno. $current_objective</div>";
                echo "<table class='table'>
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Key Result Description</th>
                            </tr>
                        </thead>
                        <tbody>";
                $kr_sno = 1;
            }
            echo "<tr>
                    <td>" . $kr_sno++ . "</td>
                    <td>" . $row['kr_desc'] . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='no-results'>No key results found.</p>";
    }
    ?>

    <a href="/GOKRT/Add/addTask.php" class="btn btn-success btn-add">Add New Tasks</a>
    <a href="/GOKRT/Add/addKR.php" class="btn btn-primary btn-add">Add New Key Result</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
