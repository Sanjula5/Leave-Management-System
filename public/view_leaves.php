<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once '../config/Database.php';
include_once '../classes/Leave.php';

$database = new Database();
$db = $database->getConnection();

$leave = new Leave($db);


$user_id = $_SESSION['user_id'];


$leaves = $leave->readLeaves($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Leaves</title>
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
        <table>
            <thead>
                <tr>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $leaves->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['type_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['reason']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="generate_pdf.php" class="back-link">Download PDF</a>
    </main>
</body>
</html>
