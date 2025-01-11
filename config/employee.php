<!-- 
Project: HR Management System 
Author: Dhruv Lathia (https://www.linkedin.com/in/dhruvlathia) 
License: MIT License 
Description: This project is open-source under the MIT license. If you reuse any part of this project, kindly provide proper credit to the author. 
Thank you for respecting the original creator's work! 
-->

<?php

session_start();

date_default_timezone_set('Asia/Kolkata');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
    header("Location: admin/dashboard.php");
    exit;
}

