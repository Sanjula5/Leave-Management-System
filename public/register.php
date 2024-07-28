<?php
session_start();
include_once '../config/Database.php';
include_once '../classes/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    

    if ($user->email == 'admin@gmail.com') {
        $user->role = 'admin';
    } else {
        $user->role = 'employee';
    }

    if ($user->userExists()) {
        $error = "User already exists. Please use a different email.";
    } else {

        if ($user->register()) {
            $success = "Registration successful. You can now log in.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Register</h1>
    </header>
    <main>
        <div class="form-container">
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="submit-button">Register</button>
            </form>
            <hr>
            <p>Already have an account? <a href="login.php" class="back-link">Login here</a></p>
        </div>
        <div class="image-container">
            <img src="images/image.jpg" alt="Login Image">
        </div>
    </main>
</body>
</html>
