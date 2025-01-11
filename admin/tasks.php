<!-- 
Project: HR Management System 
Author: Dhruv Lathia (https://www.linkedin.com/in/dhruvlathia) 
License: MIT License 
Description: This project is open-source under the MIT license. If you reuse any part of this project, kindly provide proper credit to the author. 
Thank you for respecting the original creator's work! 
-->

<?php
session_start();

if ($_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$host = 'localhost';
$username = 'root'; 
$password = '';     
$dbname = 'hr'; 
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "
    SELECT t.id, t.title, t.description, t.date, u.username, u.mobile
    FROM task t
    JOIN users u ON t.uid = u.id
    ORDER BY t.date DESC
";

$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../components/header.php'; ?>

    <div class="container mt-5">
        <h1>Employee Tasks</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Task Name</th>
                        <th>Task Description</th>
                        <th>Assigned By</th>
                        <th>Mobile</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['mobile']; ?></td>
                            <td><?php echo date('d-m-Y H:i', strtotime($row['date'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No tasks found.</div>
        <?php endif; ?>
    </div>

    <?php include '../components/footer.php'; ?>
</body>

</html>
