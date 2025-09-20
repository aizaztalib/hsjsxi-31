<?php
session_start();
$conn = new mysqli("localhost", "root", "", "slmsdb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch only approved leaves
$query = "
    SELECT tblleaves.id, tblstudents.FirstName, tblstudents.LastName, 
           tblleaves.LeaveType, tblleaves.AppliedDate
    FROM tblleaves 
    JOIN tblstudents ON tblstudents.id = tblleaves.studentid 
    WHERE tblleaves.Status = 1
    ORDER BY tblleaves.AppliedDate DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Approved Leaves | SLMS</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fa; }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #009688;
            position: fixed;
            top: 0;
            left: 0;
            color: white;
            padding-top: 20px;
            overflow-y: auto;
        }
        .sidebar h2 { text-align: center; margin-bottom: 20px; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li { padding: 10px 20px; }
        .sidebar ul li a { color: white; text-decoration: none; display: block; }
        .sidebar ul li a:hover { background-color: #00796b; border-radius: 4px; }
        ul ul { display: none; padding-left: 15px; }
        ul ul li { padding: 6px 0; }

        .main-content {
            margin-left: 260px;
            padding: 40px;
        }

        h1 {
            text-align: center;
            color: #009688;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #009688;
            color: white;
        }

        .status-approved {
            color: green;
            font-weight: bold;
        }

        .btn {
            padding: 6px 10px;
            background-color: #2196F3;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="dashboard.php">🏠 Dashboard</a></li>
        <li>
            <a href="javascript:void(0);" onclick="toggleStudentMenu()">🧑‍🎓 Students ▼</a>
            <ul id="student-submenu">
                <li><a href="students.php">➕ Add Student</a></li>
                <li><a href="students.php">⚙️ Manage Students</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="toggleDeptMenu()">🏢 Departments ▼</a>
            <ul id="dept-submenu">
                <li><a href="adddepartment.php">➕ Add Department</a></li>
                <li><a href="managedepartments.php">📋 Manage Departments</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="toggleLeaveMenu()">📝 Leaves ▼</a>
            <ul id="leave-submenu">
                <li><a href="addleave.php">➕ Add Leave</a></li>
                <li><a href="manageleaves.php">📋 Manage Leaves</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="toggleLeaveManageMenu()">📤 Leave Management ▼</a>
            <ul id="leave-manage-submenu">
                <li><a href="allleaves.php">📋 All Leaves</a></li>
                <li><a href="pendingleaves.php">⏳ Pending</a></li>
                <li><a href="approvedleaves.php">✔️ Approved</a></li>
                <li><a href="notapprovedleaves.php">❌ Not Approved</a></li>
            </ul>
        </li>
        <li><a href="change-password.php">🔑 Change Password</a></li>
        <li><a href="logout.php">🚪 Sign Out</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <h1>✅ Approved Leaves</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Leave Type</th>
                <th>Posting Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $row['FirstName'] . ' ' . $row['LastName'] ?></td>
                <td><?= $row['LeaveType'] ?></td>
                <td><?= date("d-M-Y", strtotime($row['AppliedDate'])) ?></td>
                <td class="status-approved">✔️ Approved</td>
                <td>
                    <a href="viewapprovedleaves.php?id=<?= $row['id'] ?>" class="btn">👁️ View</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function toggleStudentMenu() {
    let menu = document.getElementById("student-submenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
function toggleDeptMenu() {
    let menu = document.getElementById("dept-submenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
function toggleLeaveMenu() {
    let menu = document.getElementById("leave-submenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
function toggleLeaveManageMenu() {
    let menu = document.getElementById("leave-manage-submenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
</script>

</body>
</html>
                                          