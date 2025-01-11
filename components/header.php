<!-- 
Project: HR Management System 
Author: Dhruv Lathia (https://www.linkedin.com/in/dhruvlathia) 
License: MIT License 
Description: This project is open-source under the MIT license. If you reuse any part of this project, kindly provide proper credit to the author. 
Thank you for respecting the original creator's work! 
-->

<?php
$userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'guest';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">HR Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if ($userType === 'guest') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/hr-management/login.php">Login</a>
                    </li>
                <?php elseif ($userType === 'admin') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/hr-management/admin/dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/hr-management/admin/employee.php">Employees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/hr-management/admin/newemployee.php">Add Employee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/hr-management/admin/tasks.php">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/hr-management/logout.php">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/hr-management/dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/hr-management/task.php">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/hr-management/leave.php">Leaves</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/hr-management/profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/hr-management/logout.php">Logout</a>
                    </li>
                    
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
