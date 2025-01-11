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

$leave_balance_query = "SELECT type, salary FROM users WHERE id = $uid";
$leave_balance_result = $conn->query($leave_balance_query);
$leave_balance = $leave_balance_result->fetch_assoc();

if (isset($_POST['apply_leave'])) {
    $start_date = $conn->real_escape_string($_POST['start_date']);
    $end_date = $conn->real_escape_string($_POST['end_date']);
    $reason = $conn->real_escape_string($_POST['reason']);
    $status = 'pending';

    $query = "INSERT INTO leaves (uid, start_date, end_date, reason, status) VALUES ($uid, '$start_date', '$end_date', '$reason', '$status')";
    if ($conn->query($query)) {
        $message = "Leave application submitted successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$query = "SELECT * FROM leaves WHERE uid = $uid ORDER BY start_date DESC";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave - HR Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="container mt-5">
        <h1>Leave Management</h1>

        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="mb-4">
            <h3>Your Leave Balance</h3>
            <p>Leave Type: <strong><?php echo $leave_balance['type']; ?></strong></p>
            <p>Monthly Salary: <strong>₹<?php echo $leave_balance['salary']; ?></strong></p>
        </div>

        <form method="POST" action="leave.php" class="mb-4">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason</label>
                <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
            </div>
            <button type="submit" name="apply_leave" class="btn btn-primary">Apply for Leave</button>
        </form>

        <div class="card">
            <div class="card-body">
                <h4>Leave Applications</h4>
                <?php if ($result->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <strong>From:</strong> <?php echo $row['start_date']; ?>
                                <strong>To:</strong> <?php echo $row['end_date']; ?><br>
                                <strong>Reason:</strong> <?php echo htmlspecialchars($row['reason']); ?><br>
                                <strong>Status:</strong>
                                <?php if ($row['status'] == 'approved'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php elseif ($row['status'] == 'rejected'): ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">No leave applications yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
</body>

</html>