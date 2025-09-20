<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "slmsdb";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add new student when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $StudentId = $_POST['StudentId'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $EmailId = $_POST['EmailId'];
    $Password = $_POST['Password'];
    $Gender = $_POST['Gender'];
    $Dob = $_POST['Dob'];
    $Department = $_POST['Department'];
    $Address = $_POST['Address'];
    $City = $_POST['City'];
    $Country = $_POST['Country'];
    $PhoneNumber = $_POST['PhoneNumber'];

    $insert_sql = "INSERT INTO tblstudents 
    (StudentId, FirstName, LastName, EmailId, Password, Gender, Dob, Department, Address, City, Country, PhoneNumber) 
    VALUES 
    ('$StudentId', '$FirstName', '$LastName', '$EmailId', '$Password', '$Gender', '$Dob', '$Department', '$Address', '$City', '$Country', '$PhoneNumber')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('New student added successfully.'); window.location.href='managestudent.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to add student.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student | SLMS</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #009688;
            position: fixed;
            top: 0;
            left: 0;
            color: white;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
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
            background-color: #00796b;
            border-radius: 4px;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
        }

        .header {
            background-color: #009688;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            background: white;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input, select, textarea {
            padding: 8px;
            width: 95%;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .full-width {
            grid-column: span 2;
        }

        .submit-btn {
            background-color: #009688;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #00796b;
        }
    </style>
</head>
<body>

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
                <li><a href="managedepartments.php">📋 Manage Departments</a></li>
                <li><a href="adddepartment.php">➕ Add Department</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="toggleLeaveMenu()">📝 Leaves ▼</a>
            <ul id="leave-submenu">
                <li><a href="addleave.php">➕ Add Leave</a></li>
                <li><a href="manageleaves.php">📋 Manage Leaves</a></li>
            </ul>
        </li>
        <li><a href="manageleaves.php">📤 Leave Management</a></li>
        <li><a href="change-password.php">🔑 Change Password</a></li>
        <li><a href="logout.php">🚪 Sign Out</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header">
        <h1>Add New Student</h1>
    </div>

    <div class="content">
        <h2>Enter Student Details</h2>
        <form method="POST">
            <div>
                <label>Student ID</label>
                <input type="text" name="StudentId" required>
            </div>

            <div>
                <label>First Name</label>
                <input type="text" name="FirstName" required>
            </div>

            <div>
                <label>Last Name</label>
                <input type="text" name="LastName" required>
            </div>

            <div>
                <label>Email</label>
                <input type="email" name="EmailId" required>
            </div>

            <div>
                <label>Password</label>
                <input type="text" name="Password" required>
            </div>

            <div>
                <label>Gender</label>
                <select name="Gender" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div>
                <label>DOB</label>
                <input type="date" name="Dob">
            </div>

            <div>
                <label>Department</label>
                <input type="text" name="Department">
            </div>

            <div>
                <label>Address</label>
                <textarea name="Address"></textarea>
            </div>

            <div>
                <label>City</label>
                <input type="text" name="City">
            </div>

            <div>
                <label>Country</label>
                <input type="text" name="Country">
            </div>

            <div>
                <label>Phone Number</label>
                <input type="text" name="PhoneNumber">
            </div>

            <div class="full-width">
                <button type="submit" class="submit-btn">Add Student</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
