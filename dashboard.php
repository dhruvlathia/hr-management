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
$today = date('Y-m-d');

if (isset($_POST['punch_in'])) {
    $current_time = date('H:i:s');
    $query = "SELECT * FROM time WHERE uid = $uid AND date = '$today'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $time_array = json_decode($row['time'], true);
        $time_array[] = $current_time;
        $time_json = json_encode($time_array);
        $update_query = "UPDATE time SET time = '$time_json' WHERE id = " . $row['id'];
        $conn->query($update_query);
    } else {
        // Insert new entry
        $time_json = json_encode([$current_time]);
        $insert_query = "INSERT INTO time (uid, time, date) VALUES ($uid, '$time_json', '$today')";
        $conn->query($insert_query);
    }
    $message = "Punch-in recorded at $current_time.";
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['punch_out'])) {
    $current_time = date('H:i:s');
    $query = "SELECT * FROM time WHERE uid = $uid AND date = '$today'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $time_array = json_decode($row['time'], true);
        $time_array[] = $current_time;
        $time_json = json_encode($time_array);
        $update_query = "UPDATE time SET time = '$time_json' WHERE id = " . $row['id'];
        $conn->query($update_query);
    } else {
        $message = "Please punch in first!";
    }
    $message = "Punch-out recorded at $current_time.";

    header("Location: dashboard.php");
    exit;
}

$query = "SELECT * FROM time WHERE uid = $uid AND date = '$today'";
$result = $conn->query($query);
$total_time = '00:00:00';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $time_array = json_decode($row['time'], true);
    $pairs = array_chunk($time_array, 2);
    $total_seconds = 0;

    foreach ($pairs as $pair) {
        if (count($pair) == 2) {
            $start_time = strtotime($pair[0]);
            $end_time = strtotime($pair[1]);
            $total_seconds += ($end_time - $start_time);
        }
    }

    $hours = floor($total_seconds / 3600);
    $minutes = floor(($total_seconds % 3600) / 60);
    $seconds = $total_seconds % 60;
    $total_time = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HR Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="container mt-5">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <p class="text-muted">Date: <?php echo $today; ?></p>

        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="dashboard.php" class="mb-4">

            <?php (!isset($time_array) || count($time_array) % 2 == 0) ? print '<button type="submit" name="punch_in" class="btn btn-success">Punch In</button>' : print '<button type="submit" name="punch_out" class="btn btn-danger">Punch Out</button>' ?>

        </form>

        <div class="card">
            <div class="card-body">
                <h4>Total Time Worked Today</h4>
                <p class="h2 text-primary"><?php echo $total_time; ?></p>
            </div>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h4>Punch Times Today</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Punch In</th>
                                <th>Punch Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;

                            foreach ($pairs as $pair):
                                $start_time = new DateTime($pair[0]);  // Create a DateTime object for the punch-in time
                                $formatted_start_time = $start_time->format('h:i A');  // Format it to AM/PM
                        
                                // Check if punch-out time exists and format it to AM/PM
                                $formatted_end_time = isset($pair[1]) ? (new DateTime($pair[1]))->format('h:i A') : '~';
                                ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo $formatted_start_time; ?></td>
                                    <td><?php echo $formatted_end_time; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'components/footer.php'; ?>
</body>

</html>