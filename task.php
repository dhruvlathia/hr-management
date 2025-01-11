<!-- 
Project: HR Management System 
Author: Dhruv Lathia (https://www.linkedin.com/in/dhruvlathia) 
License: MIT License 
Description: This project is open-source under the MIT license. If you reuse any part of this project, kindly provide proper credit to the author. 
Thank you for respecting the original creator's work! 
-->

<?php
include 'config/employee.php';
include 'config/db.php';

$uid = $_SESSION['user_id'];
$message = '';

if (isset($_POST['submit_task'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $date = date('Y-m-d');

    $query = "INSERT INTO task (uid, title, description, date) VALUES ($uid, '$title', '$description', '$date')";
    if ($conn->query($query)) {
        $message = "Task added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$query = "SELECT * FROM task WHERE uid = $uid ORDER BY date DESC";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task - HR Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="container mt-5">
        <h1>Your Tasks</h1>

        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="task.php" class="mb-4">
            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit_task" class="btn btn-primary">Add Task</button>
        </form>

        <div class="card">
            <div class="card-body">
                <h4>Task History</h4>
                <?php if ($result->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                <?php echo nl2br(htmlspecialchars($row['description'])); ?><br>
                                <small class="text-muted">Date: <?php echo $row['date']; ?></small>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">No tasks added yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
</body>

</html>