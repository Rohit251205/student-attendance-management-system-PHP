<?php
$conn = mysqli_connect("localhost", "root", "", "attendance_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM reports";
$result = mysqli_query($conn, $sql);
?>

<html>
<head>
    <title>Student Reports</title>
    <style>
          body {
               font-family: Arial, sans-serif;
               background-color: #f4f4f4;
               margin: 0;
               padding: 0;
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
               width: 85%;
               margin: 30px auto;
               background: white;
               padding: 20px;
               box-shadow: 0px 0px 10px gray;
               border-radius: 8px;
          }

          h2 {
               text-align: center;
               color: #333;
          }

          h1 {
               text-align: center;
               color: #333;
               margin-top: 100px;
          }

          table {
               width: 100%;
               border-collapse: collapse;
               margin-top: 20px;
          }

          th, td {
               padding: 10px;
               text-align: center;
               border-bottom: 1px solid #ddd;
          }

          th {
               background-color: #4CAF50;
               color: white;
          }

          tr:hover {
               background-color: #f5f5f5;
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

     <h1>Student Reports</h1>
     <div class="container">
          <h2>Report List</h2>
          <table>
               <tr>
                    <th>Roll Number</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Report Type</th>
                    <th>Details</th>
                    <th>Faculty Email</th>
                    <th>Date & Time</th>
               </tr>
               <?php
               if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                         echo "<tr>";
                         echo "<td>" . $row['rollno'] . "</td>";
                         echo "<td>" . $row['name'] . "</td>";
                         echo "<td>" . $row['class'] . "</td>";
                         echo "<td>" . $row['report_type'] . "</td>";
                         echo "<td>" . $row['report_details'] . "</td>";
                         echo "<td>" . $row['fact_email'] . "</td>";
                         echo "<td>" . $row['created_at'] . "</td>";
                         echo "</tr>";
                    }
               } else {
                    echo "<tr><td colspan='7'>No reports found.</td></tr>";
               }
               ?>
          </table>
     </div>
</body>
</html>

<?php
mysqli_close($conn);
?>