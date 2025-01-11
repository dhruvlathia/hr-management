<!-- 
Project: HR Management System 
Author: Dhruv Lathia (https://www.linkedin.com/in/dhruvlathia) 
License: MIT License 
Description: This project is open-source under the MIT license. If you reuse any part of this project, kindly provide proper credit to the author. 
Thank you for respecting the original creator's work! 
-->

<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/style.css" class="assets">
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="container mt-5 hero-section">
        <div class="text-center">
            <h1 class="hero-title">Welcome to HR Management</h1>
            <p class="hero-subtitle">Efficiently manage your workforce with our powerful, intuitive, and user-friendly
                HR system!</p>
            <div class="hero-buttons">
                <?php if (!isset($_SESSION['user_type'])): ?>
                    <a href="login.php" class="btn btn-primary">Login</a>
                    <!-- <a href="register.php" class="btn btn-success">Register</a> -->
                <?php else: ?>
                    <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container features-section">
        <h2 class="features-title">Our Key Features</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Employee Management</h4>
                    <p class="feature-text">Easily manage employee profiles, track performance, and monitor attendance with ease.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Analytics & Reports</h4>
                    <p class="feature-text">Generate insightful reports to make informed decisions with advanced
                        analytics tools.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4>Leaves and Tasks</h4>
                    <p class="feature-text">Manage leaves and tasks efficiently, ensuring a smooth workflow.</p>
                </div>
            </div>
        </div>
    </div>


    <?php include 'components/footer.php'; ?>
</body>

</html>