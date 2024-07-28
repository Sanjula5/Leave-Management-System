<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../public/login.php");
    exit();
}

include_once '../config/Database.php';
include_once '../classes/LeaveType.php';

$database = new Database();
$db = $database->getConnection();

$leaveType = new LeaveType($db);

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['type_name'])) {
    $leaveType->type_name = $_POST['type_name'];
    if ($leaveType->create()) {
        $success = "Leave type added successfully.";
    } else {
        $error = "Unable to add leave type. Please try again.";
    }
}

$leaveTypes = $leaveType->read();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Leave Types</title>
    <link rel="stylesheet" href="admin_styles.css">
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
        <div class="container">
            <h1>Manage Leave Types</h1>
            <?php if ($success): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="post">
                <input type="text" name="type_name" placeholder="Leave Type" required>
                <button type="submit" class="add-button">Add Leave Type</button>
            </form>
            <h2>Existing Leave Types</h2>
            <ul class="leave-type-list">
                <?php while ($row = $leaveTypes->fetch(PDO::FETCH_ASSOC)): ?>
                    <li><?php echo htmlspecialchars($row['type_name']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </main>
</body>
</html>
