<?php
session_start();
include_once '../config/Database.php';
include_once '../classes/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->login()) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['role'] = $user->role;
        
        if ($user->role == 'admin') {
            header("Location: ../admin/admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <main>
        <div class="form-container">
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="post">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="submit-button">Login</button>
            </form>
            <hr>
            <p>Don't have an account? <a href="register.php" class="back-link">Register here</a></p>
        </div>
        <div class="image-container">
            <img src="images/image.jpg" alt="Login Image">
        </div>
    </main>
</body>
</html>
