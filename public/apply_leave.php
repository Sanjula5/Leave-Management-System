<?php
session_start();


include_once '../config/database.php';
include_once '../classes/Leave.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$database = new Database();
$db = $database->getConnection();
$leave = new Leave($db);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave->user_id = $_SESSION['user_id'];
    $leave->type_id = $_POST['type_id'];
    $leave->start_date = $_POST['start_date'];
    $leave->end_date = $_POST['end_date'];
    $leave->reason = $_POST['reason'];


    if ($leave->applyLeave()) {
        $success = "Leave applied successfully.";
    } else {
        $error = "Failed to apply leave. Please try again.";
    }
}


$leaveTypes = $leave->getLeaveTypes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Leave</title>
    <link rel="stylesheet" href="styles.css">
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
        <section class="form-container">
            <h1>Apply for Leave</h1>
            <?php if (isset($success)): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <p class="message"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="apply_leave.php">
                <label for="type_id">Leave Type:</label>
                <select id="type_id" name="type_id" required>
                    <?php
                    while ($row = $leaveTypes->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['type_name']) . "</option>";
                    }
                    ?>
                </select>

                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>

                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>

                <label for="reason">Reason:</label>
                <textarea id="reason" name="reason" rows="4" required></textarea>

                <input type="submit" value="Apply Leave">
            </form>
            <a href="index.php" class="back-link">Back to Home</a>
        </section>
    </main>
</body>
</html>
