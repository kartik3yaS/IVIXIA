<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Objectives</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Objectives List</h2>

    <?php
    $sql = "
        SELECT g.goal_id, g.goal_title, g.goal_desc, o.objective_title, o.objective_desc 
        FROM goals AS g 
        LEFT JOIN objective AS o ON g.goal_id = o.goal_id
        ORDER BY g.goal_id
    ";
    $result = mysqli_query($conn, $sql);
    $currentGoalId = null;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($currentGoalId !== $row['goal_id']) {
                if ($currentGoalId !== null) {
                    echo "</ul></div>";
                }
                $currentGoalId = $row['goal_id'];

                echo "
                <div class='card mb-3'>
                    <div class='card-header'>
                        <h5 class='mb-0'>
                            <button class='btn btn-link' data-bs-toggle='modal' data-bs-target='#goalModal{$currentGoalId}'>
                                " . htmlspecialchars($row['goal_title']) . "
                            </button>
                        </h5>
                    </div>
                    <div class='card-body'>
                        <ul class='list-group'>";
            }
            if ($row['objective_title']) {
                echo "<li class='list-group-item'>" . htmlspecialchars($row['objective_title']) . "</li>";
            }
        }
        echo "</ul></div></div>";
    } else {
        echo "<p class='text-center'>No objectives found.</p>";
    }
    ?>

    <div class="text-center mt-4">
        <a href="/GOKRT/Add/addKR.php" class="btn btn-primary">Add Key Results</a>
        <a href="/GOKRT/Add/addObjective.php" class="btn btn-secondary">Add Objective</a>
    </div>
</div>

<?php
mysqli_data_seek($result, 0);
$currentGoalId = null;

while ($row = mysqli_fetch_assoc($result)) {
    if ($currentGoalId !== $row['goal_id']) {
        $currentGoalId = $row['goal_id'];

        echo "
        <div class='modal fade' id='goalModal{$currentGoalId}' tabindex='-1' aria-labelledby='goalModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='goalModalLabel'>" . htmlspecialchars($row['goal_title']) . "</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <p><strong>Description:</strong></p>
                        <p>" . htmlspecialchars($row['goal_desc']) . "</p>
                    </div>
                </div>
            </div>
        </div>";
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
