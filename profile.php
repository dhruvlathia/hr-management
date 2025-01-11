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

$query = "SELECT * FROM users WHERE id = $uid";
$result = $conn->query($query);
$user = $result->fetch_assoc();

if (isset($_POST['update_profile'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $age = $conn->real_escape_string($_POST['age']);
    $salary = $conn->real_escape_string($_POST['salary']);

    $social_media = [];
    if (isset($_POST['platform']) && isset($_POST['link'])) {
        for ($i = 0; $i < count($_POST['platform']); $i++) {
            if ($_POST['platform'][$i] && $_POST['link'][$i]) {
                $social_media[] = [
                    'platform' => $_POST['platform'][$i],
                    'link' => $_POST['link'][$i]
                ];
            }
        }
    }
    $social_media_json = json_encode($social_media);

    $query = "UPDATE users SET username = '$username', email = '$email', mobile = '$mobile', age = '$age', salary = '$salary', social_media_links = '$social_media_json' WHERE id = $uid";
    if ($conn->query($query)) {
        $message = "Profile updated successfully!";
        $user = array_merge($user, $_POST);
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - HR Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addSocialMedia() {
            var container = document.getElementById('social-media-container');
            var newDiv = document.createElement('div');
            newDiv.classList.add('mb-3');
            newDiv.innerHTML = `
                <label for="platform" class="form-label">Platform</label>
                <input type="text" class="form-control" name="platform[]" required>
                <label for="link" class="form-label">Link</label>
                <input type="url" class="form-control" name="link[]" required>
            `;
            container.appendChild(newDiv);
        }
    </script>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="container mt-5">
        <h1>Profile</h1>

        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="profile.php" class="mb-4">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile"
                    value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age"
                    value="<?php echo htmlspecialchars($user['age']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary (per month)</label>
                <input type="number" class="form-control" id="salary" name="salary"
                    value="<?php echo htmlspecialchars($user['salary']); ?>" required>
            </div>
            <h4>Social Media Links</h4>
            <div id="social-media-container">
                <?php
                $social_media = json_decode($user['social_media_links'], true);
                if ($social_media) {
                    foreach ($social_media as $sm) {
                        echo '<div class="mb-3">
                                <label for="platform" class="form-label">Platform</label>
                                <input type="text" class="form-control" name="platform[]" value="' . htmlspecialchars($sm['platform']) . '" required>
                                <label for="link" class="form-label">Link</label>
                                <input type="url" class="form-control" name="link[]" value="' . htmlspecialchars($sm['link']) . '" required>
                              </div>';
                    }
                }
                ?>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addSocialMedia()">+</button>
            <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <?php include 'components/footer.php'; ?>
</body>

</html>