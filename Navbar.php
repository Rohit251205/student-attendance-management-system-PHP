<?php
session_start();

if (!isset($_SESSION['email'])) {
     header("Location: Login.php");
     exit();
}
?>

<htm>
<head>
    <title>Attendance Management System</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: lightgray;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(10px);
            background: rgba(0, 0, 0, 0.3);
            z-index: -1;
        }

        header {
            background: rgba(0, 0, 0, 0.9);
            color: #fff;
            padding: 15px 0;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            border-bottom: 3px solid #77a7ff;
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 70px;
            font-size: 18px;
            font-weight: bold;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #77a7ff;
            text-decoration: underline;
        }

        .container {
            text-align: center;
            color: #fff;
            margin-top: 150px;
            padding: 0 20px;
        }

        .container h1 {
            font-size: 48px;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .container h1 span {
            font-size: 70px;
            color: rgba(0, 191, 255, 0.8);
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .container p {
            font-size: 20px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 14px 30px;
            font-size: 18px;
            color: #fff;
            background: #77a7ff;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="background-overlay"></div>

    <header>
        <div class="navbar">
            <a href="Navbar.php">Home</a>                         
            <a href="manage_student.php">Manage Student</a>            
            <a href="attendance.php">Attendance</a>
            <a href="report.php">Report</a>
            <a href="contact_us.php">Contact Us</a> 
            <a href="Login.php">Logout</a>
        </div>
    </header>

    <div class="container">
        <h1><span>W</span>elcome <span>T</span>o <span>A</span>ttendance <span>M</span>anagement <span>S</span>ystem</h1>
        <p>Effortlessly track and manage student attendance with accuracy and efficiency. Our system simplifies attendance tracking, ensures data integrity, and enhances the teaching experience.</p>
        <p>Easy student attendance tracking<br>Accurate and secure record-keeping<br>Generate reports with one click<br>Improve productivity and efficiency<br>User-friendly interface for seamless operation</p>
    </div>
</body>
</html>