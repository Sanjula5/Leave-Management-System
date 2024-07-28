<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_styles.css">
    <style>
        .welcome-section {
            background: #f9f9f9;
            border: 1px solid #e1e1e1;
            border-radius: 10px;
            padding: 30px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .welcome-section h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .welcome-section p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .highlight {
            color: #007bff;
            font-weight: bold;
        }
        .cta {
            display: block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .cta:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="manage_leaves.php" class="nav-button manage-leaves">Manage Leaves</a>
            <a href="manage_leave_types.php" class="nav-button manage-leave-types">Manage Leave Types</a>
            <a href="/public/login.php" class="nav-button logout">Logout</a>
        </nav>
    </header>
    <main>
        <section class="welcome-section">
            <h2>Welcome Back, Admin!</h2>
            <p>
                <strong>The Leave Management System</strong> is designed to <span class="highlight">streamline and automate</span> the process of managing employee leave requests. As an admin, you have the ability to oversee and control various aspects of the system to ensure smooth operation and effective leave management. Here’s what you can do:
            </p>
            <div class="image-container">
            <img src="images/12.jpg" alt="Login Image">
        </div>

        </section>
    </main>
</body>
</html>

