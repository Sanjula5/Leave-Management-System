<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Management System</title>
    <link rel="stylesheet" href="styles.css">
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
        <h1>Leave Management System</h1>
        <nav>
            <a href="apply_leave.php" class="nav-button apply-leave">Apply for Leave</a>
            <a href="view_leaves.php" class="nav-button view-leaves">View Leaves</a>
            <a href="logout.php" class="nav-button logout">Logout</a>
        </nav>
    </header>
    <main>
    <section class="welcome-section">
    <h2>Welcome Back!</h2>
    <p>The Leave Management System simplifies the process of handling student leave requests. It provides a streamlined platform for students to submit their leave applications and for administrators to review and manage these requests efficiently.</p>
    <div class="image-container">
            <img src="images/ws.png" alt="Login Image">
        </div>
</section>

    </main>
</body>
</html>
