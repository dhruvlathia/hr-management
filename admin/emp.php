<!-- 
Project: HR Management System 
Author: Dhruv Lathia (https://www.linkedin.com/in/dhruvlathia) 
License: MIT License 
Description: This project is open-source under the MIT license. If you reuse any part of this project, kindly provide proper credit to the author. 
Thank you for respecting the original creator's work! 
-->

<?php
include '../config/admin.php';
include '../config/db.php';

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $employee = $result->fetch_assoc();
    $social_media_links = json_decode($employee['social_media_links'], true); // Decode the JSON into an array
} else {
    echo "Employee not found.";
    exit;
}

$message = '';

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $age = $_POST['age'];
    $salary = $_POST['salary'];

    // Encode social media links array to JSON
    $social_media = json_encode($_POST['social_media']);

    $update_query = "UPDATE users SET username = '$username', email = '$email', mobile = '$mobile', age = '$age', salary = '$salary', social_media_links = '$social_media', updated_at = NOW() WHERE id = $id";
    if ($conn->query($update_query) === TRUE) {
        $message = "Employee information updated successfully.";
    } else {
        $message = "Error updating employee information: " . $conn->error;
    }
}

if (isset($_POST['delete'])) {
    $delete_query = "DELETE FROM users WHERE id = $id";
    if ($conn->query($delete_query) === TRUE) {
        $message = "Employee deleted successfully.";
        header("Location: employees.php"); // Redirect to employee list page after deletion
        exit;
    } else {
        $message = "Error deleting employee: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../components/header.php'; ?>

    <div class="container mt-5">
        <h1>Employee Details</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $employee['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $employee['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $employee['mobile']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="<?php echo $employee['age']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary (per month)</label>
                <input type="number" class="form-control" id="salary" name="salary" value="<?php echo $employee['salary']; ?>" required>
            </div>

            <h5>Social Media Links</h5>
            <div id="social-media-container">
                <?php foreach ($social_media_links as $index => $link): ?>
                    <div class="mb-3 social-media-entry">
                        <label for="platform_<?php echo $index; ?>" class="form-label">Platform</label>
                        <input type="text" class="form-control" id="platform_<?php echo $index; ?>" name="social_media[<?php echo $index; ?>][platform]" value="<?php echo $link['platform']; ?>" required>
                        <label for="link_<?php echo $index; ?>" class="form-label">Link</label>
                        <input type="url" class="form-control" id="link_<?php echo $index; ?>" name="social_media[<?php echo $index; ?>][link]" value="<?php echo $link['link']; ?>" required>
                        <?php if ($index > 0): ?>
                            <button type="button" class="btn btn-danger remove-social-media" data-index="<?php echo $index; ?>">Remove</button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <button type="button" id="add-social-media" class="btn btn-success">+</button>
            </div>
            

            <button type="submit" name="update" class="btn btn-primary mt-3">Update Information</button>
            <button type="submit" name="delete" class="btn btn-danger mt-3" onclick="return confirm('Are you sure you want to delete this employee?')">Delete Employee</button>
        </form>
    </div>

    <?php include '../components/footer.php'; ?>

    <script>
        document.getElementById('add-social-media').addEventListener('click', function() {
            var index = document.querySelectorAll('.social-media-entry').length;
            var newEntry = `
                <div class="mb-3 social-media-entry">
                    <label for="platform_${index}" class="form-label">Platform</label>
                    <input type="text" class="form-control" id="platform_${index}" name="social_media[${index}][platform]" required>
                    <label for="link_${index}" class="form-label">Link</label>
                    <input type="url" class="form-control" id="link_${index}" name="social_media[${index}][link]" required>
                    <button type="button" class="btn btn-danger remove-social-media" data-index="${index}">Remove</button>
                </div>
            `;
            document.getElementById('social-media-container').insertAdjacentHTML('beforeend', newEntry);
        });

        document.getElementById('social-media-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-social-media')) {
                var index = e.target.dataset.index;
                e.target.closest('.social-media-entry').remove();
            }
        });
    </script>
</body>

</html>
