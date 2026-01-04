<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "attendance_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "
    SELECT 
        (SELECT COUNT(*) FROM teachers) AS faculty_count,
        (SELECT COUNT(*) FROM students) AS student_count,
        (SELECT COUNT(*) FROM reports) AS report_count,
        (SELECT COUNT(*) FROM users) AS user_count
";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

$facultyCount = $data['faculty_count'];
$studentCount = $data['student_count'];
$reportCount = $data['report_count'];
$userCount = $data['user_count'];

$conn->close();
?>

<html>
<head>
    <title>Dashboard</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        header {
            background: #333;
            color: #fff;
            padding: 15px 0;
            width: 100%;
            border-bottom: 3px solid #77a7ff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            font-size: 18px;
            font-weight: bold;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            transition: color 0.3s ease-in-out;
        }

        .navbar a:hover {
            color: #77a7ff;
            text-decoration: underline;
        }

        .dashboard-container {
            max-width: 900px;
            margin: 100px auto 20px;
            padding: 20px;
            text-align: center;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two columns per row */
            gap: 20px;
            margin-top: 40px;
        }

        .card {
            border-radius: 10px;
            padding: 25px;
            color: white;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        
        .card .number {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .red { 
            background-color: #e74c3c; 
        }

        .orange { 
            background-color: #f39c12; 
        }

        .purple { 
            background-color: #9b59b6; 
        }

        .blue { 
            background-color: #3498db; 
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="dashboard.php">Dashboard</a>                        
            <a href="faculty_att.php">Faculty Attendance</a>            
            <a href="view_faculty_att.php">View Faculty Att.</a>
            <a href="stu_att.php">View Student Att.</a>
            <a href="report_std.php">Student Report</a>
            <a href="manage_faculty.php">Manage Faculty</a> 
            <a href="adminlogin.php">Logout</a>
        </div>
    </header>

    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>
        <div class="card-container">
            <div class="card red">
                <div class="number"><?php echo $facultyCount; ?></div>
                Faculties
            </div>
            <div class="card orange">
                <div class="number"><?php echo $studentCount; ?></div>
                Students
            </div>
            <div class="card purple">
                <div class="number"><?php echo $reportCount; ?></div>
                Reports
            </div>
            <div class="card blue">
                <div class="number"><?php echo $userCount; ?></div>
                Users
            </div>
        </div>
    </div>
</body>
</html>