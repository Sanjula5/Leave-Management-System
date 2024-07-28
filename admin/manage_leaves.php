<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../public/login.php");
    exit();
}

include_once '../config/Database.php';
include_once '../classes/Leave.php';

$database = new Database();
$db = $database->getConnection();
$leave = new Leave($db);


$success = $error = "";
$leave_type_filter = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['leave_id']) && isset($_POST['status'])) {

        $leave->id = $_POST['leave_id'];
        $leave->status = $_POST['status'];
        if ($leave->updateStatus()) {
            $success = "Leave status updated successfully.";
            echo "<script>showPopup('success', 'Leave status updated successfully.');</script>";
        } else {
            $error = "Unable to update leave status. Please try again.";
            echo "<script>showPopup('error', 'Unable to update leave status. Please try again.');</script>";
        }
    } elseif (isset($_POST['delete_leave_id'])) {

        $leave->id = $_POST['delete_leave_id'];
        if ($leave->delete()) {
            $success = "Leave deleted successfully.";
            echo "<script>showPopup('success', 'Leave deleted successfully.');</script>";
        } else {
            $error = "Unable to delete leave. Please try again.";
            echo "<script>showPopup('error', 'Unable to delete leave. Please try again.');</script>";
        }
    }
}


if (isset($_POST['leave_type_filter'])) {
    $leave_type_filter = $_POST['leave_type_filter'];
}


$leaves = $leave->readLeavesByType($leave_type_filter);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Leaves</title>
    <link rel="stylesheet" href="admin_styles.css">
    <style>
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 20%;
            transform: translateX(-50%);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            font-size: 16px;
            width: 300px;
            text-align: center;
        }

        .popup.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .popup.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .popup.show {
            display: block;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @keyframes fadeout {
            from {opacity: 1;}
            to {opacity: 0;}
        }
    </style>
    <script>
        function showPopup(type, message) {
            var popup = document.createElement('div');
            popup.className = 'popup ' + type + ' show';
            popup.innerText = message;
            document.body.appendChild(popup);
            setTimeout(function() {
                popup.classList.remove('show');
                document.body.removeChild(popup);
            }, 3000);
        }
    </script>
</head>
<body>
<header>
    <h1>Admin Dashboard</h1>
    <nav>
        <a href="manage_leaves.php" class="nav-button manage-leaves">Manage Leaves</a>
        <a href="manage_leave_types.php" class="nav-button manage-leave-types">Manage Leave Types</a>
        <a href="../public/login.php" class="nav-button logout">Logout</a>
    </nav>
</header>
<main>
    <div class="container">

        <form method="post" class="filter-form">
            <label for="leave_type_filter">Search by Leave Type:</label>
            <select name="leave_type_filter" id="leave_type_filter">
                <option value="">All Leave Types</option>
                <?php

                $leave_types = $leave->getLeaveTypes();
                while ($type = $leave_types->fetch(PDO::FETCH_ASSOC)) {
                    $selected = $type['id'] == $leave_type_filter ? 'selected' : '';
                    echo "<option value='{$type['id']}' $selected>{$type['type_name']}</option>";
                }
                ?>
            </select>
            <button type="submit" class="filter-button">Search</button>
        </form>


        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $leaves->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['type_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['reason']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <form method="post" class="inline-form">
                                <input type="hidden" name="leave_id" value="<?php echo $row['id']; ?>">
                                <select name="status">
                                    <option value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="approved" <?php echo $row['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                    <option value="rejected" <?php echo $row['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                                <button type="submit" class="update-button">Update</button>
                            </form>
                            <form method="post" class="inline-form">
                                <input type="hidden" name="delete_leave_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
