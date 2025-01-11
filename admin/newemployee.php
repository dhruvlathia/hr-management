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

$message = '';

if (isset($_POST['add_employee'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $mobile = $_POST['mobile'];
    $age = $_POST['age'];
    $salary = $_POST['salary'];
    $type = 'employee'; 


    $join_date = date('Y-m-d'); // Default to the current date

    $query = "INSERT INTO users (username, email, password, mobile, age, salary, type, joining_date, created_at, updated_at) 
              VALUES ('$username', '$email', '$password', '$mobile', '$age', '$salary', '$type', '$join_date', NOW(), NOW())";

    if ($conn->query($query) === TRUE) {
        $message = "New employee added successfully.";
    } else {
        $message = "Error adding employee: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../components/header.php'; ?>

    <div class="container mt-5">
        <h1>Add New Employee</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" required>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary (per month)</label>
                <input type="number" class="form-control" id="salary" name="salary" required>
            </div>

            <button type="submit" name="add_employee" class="btn btn-primary">Add Employee</button>
        </form>
    </div>

    <?php include '../components/footer.php'; ?>
</body>

</html>
