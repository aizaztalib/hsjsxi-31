<?php
session_start();
$conn = new mysqli("localhost", "root", "", "slmsdb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$approvedLeaves = $conn->query("
    SELECT tblleaves.id, tblstudents.FirstName, tblstudents.LastName, tblleaves.LeaveType, 
           tblleaves.AppliedDate, tblleaves.Status 
    FROM tblleaves 
    JOIN tblstudents ON tblstudents.id = tblleaves.studentid 
    WHERE tblleaves.Status = 1
    ORDER BY tblleaves.AppliedDate DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>SLMS | Approved Leaves</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4faff; /* light bluish like dashboard */
        }

        /* Sidebar (same as dashboard + addleave) */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #1e3c72, #2a5298);
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            color: white;
            overflow-y: auto;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px 20px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }
        .sidebar ul li a:hover {
            background-color: rgba(255,255,255,0.15);
            border-radius: 6px;
        }
        ul ul {
            display: none;
            padding-left: 15px;
        }
        ul ul li {
            padding: 6px 0;
        }

        /* Main content */
        .main-content {
            margin-left: 260px;
            padding: 40px;
        }
        h1 {
            text-align: center;
            color: #2a5298;
            margin-bottom: 30px;
        }

        /* Table styled like dashboard cards */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background-color: #2a5298;
            color: white;
        }
        tr:hover {
            background-color: #f1f5ff;
        }
        .status-approved {
            color: green;
            font-weight: bold;
        }

        /* Button */
        .btn {
            padding: 6px 12px;
            background-color: #2196F3;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="dashboard.php">🏠 Dashboard</a></li>

        <li>
            <a href="javascript:void(0);" onclick="toggleMenu('student-submenu')">🧑‍🎓 Students ▼</a>
            <ul id="student-submenu">
                <li><a href="students.php">➕ Add Student</a></li>
                <li><a href="students.php">⚙️ Manage Students</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0);" onclick="toggleMenu('dept-submenu')">🏢 Departments ▼</a>
            <ul id="dept-submenu">
                <li><a href="adddepartment.php">➕ Add Department</a></li>
                <li><a href="managedepartments.php">📋 Manage Departments</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0);" onclick="toggleMenu('leave-submenu')">📝 Leaves ▼</a>
            <ul id="leave-submenu">
                <li><a href="addleave.php">➕ Add Leave</a></li>
                <li><a href="manageleaves.php">📋 Manage Leaves</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0);" onclick="toggleMenu('leave-manage-submenu')">📤 Leave Management ▼</a>
            <ul id="leave-manage-submenu">
                <li><a href="allleaves.php">📋 All Leaves</a></li>
                <li><a href="pendingleaves.php">⏳ Pending Leaves</a></li>
                <li><a href="approvedleaves.php">✔️ Approved Leaves</a></li>
                <li><a href="notapprovedleaves.php">❌ Not Approved Leaves</a></li>
            </ul>
        </li>

        <li><a href="change-password.php">🔑 Change Password</a></li>
        <li><a href="logout.php">🚪 Sign Out</a></li>
    </ul>
</div>

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
            <?php $i = 1; while ($row = $approvedLeaves->fetch_assoc()): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']) ?></td>
                <td><?= htmlspecialchars($row['LeaveType']) ?></td>
                <td><?= date("d-M-Y", strtotime($row['AppliedDate'])) ?></td>
                <td class="status-approved">✔️ Approved</td>
                <td>
                    <a href="viewleave.php?id=<?= $row['id'] ?>" class="btn">👁️ View</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function toggleMenu(id) {
    const menu = document.getElementById(id);
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
</script>

</body>
</html>
