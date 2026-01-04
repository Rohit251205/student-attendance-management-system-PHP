<?php
$conn = mysqli_connect("localhost", "root", "", "attendance_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<html>
<head>
    <title>View Attendance Percentage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
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

        .container {
            background-color: #fff;
            margin-top: 90px;
            width: 1000px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
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

<div class="container">
    <h1>View Faculty Attendance</h1>

    <?php
    $query = "SELECT f.id, f.name, t.department, 
                     COUNT(*) AS total_days,
                     SUM(CASE WHEN f.attendance = 'Present' THEN 1 ELSE 0 END) AS present_days
              FROM faculties f
              JOIN teachers t ON f.id = t.id
              GROUP BY f.id, f.name, t.department";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Total Days</th>
                    <th>Present Days</th>
                    <th>Absent Days</th>
                    <th>Attendance %</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $total_days = $row['total_days'];
            $present_days = $row['present_days'];
            $absent_days = $total_days - $present_days;
            $percentage = ($total_days > 0) ? round(($present_days / $total_days) * 100, 2) : 0;

            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['department']}</td>
                    <td>{$total_days}</td>
                    <td>{$present_days}</td>
                    <td>{$absent_days}</td>
                    <td>{$percentage}%</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No attendance records found.</p>";
    }

    mysqli_close($conn);
    ?>
</div>
</body>
</html>