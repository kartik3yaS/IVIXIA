<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Tasks</title>
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
        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .btn-add {
            display: block;
            margin: 20px auto;
        }
        .kr-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
            text-decoration: underline; /* Underline to look like a link */
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
    <h2>Task List</h2>

    <?php
    $sql = "SELECT t.task_desc, kr.kr_desc, o.objective_title, o.objective_desc 
            FROM task t 
            JOIN kr ON t.kr_id = kr.kr_id 
            JOIN objective o ON kr.objective_id = o.objective_id 
            ORDER BY o.objective_title";
    $result = mysqli_query($conn, $sql);
    $current_kr = '';
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($current_kr != $row['kr_desc']) {
                if ($current_kr != '') {
                    echo "</tbody></table>";
                }
                $current_kr = $row['kr_desc'];
                echo "<div class='kr-header' data-bs-toggle='modal' data-bs-target='#objectiveModal' data-objective-title='" . htmlspecialchars($row['objective_title']) . "' data-objective-desc='" . htmlspecialchars($row['objective_desc']) . "'>$current_kr</div>";
                echo "<table class='table'>
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Task Description</th>
                            </tr>
                        </thead>
                        <tbody>";
                
                $sno = 1;
            }
            echo "<tr>
                    <td>" . $sno++ . "</td>
                    <td>" . $row['task_desc'] . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='no-results'>No tasks found.</p>";
    }
    ?>

    <a href="/GOKRT/Add/addTask.php" class="btn btn-success btn-add">Add New Task</a>
</div>

<div class="modal fade" id="objectiveModal" tabindex="-1" aria-labelledby="objectiveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="objectiveModalLabel">Objective Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Objective Description:</h6>
                <p id="objectiveDesc"></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const objectiveModal = document.getElementById('objectiveModal');
    objectiveModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const title = button.getAttribute('data-objective-title');
        const desc = button.getAttribute('data-objective-desc');

        const modalTitle = objectiveModal.querySelector('.modal-title');
        const modalDesc = objectiveModal.querySelector('#objectiveDesc');

        modalTitle.textContent = title;
        modalDesc.textContent = desc;
    });
</script>
</body>
</html>
