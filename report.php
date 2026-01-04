<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "attendance_db");

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['email'])) {
     header("Location: Login.php");
     exit();
}

$teacher_email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $name = $_POST['name'];
     $rollno = $_POST['rollno'];
     $class = $_POST['class'];
     $report_type = $_POST['report_type'];
     $report_details = isset($_POST['report_details']) ? $_POST['report_details'] : "";
 
     $sql = "INSERT INTO reports (name, rollno, class, report_type, report_details, fact_email) 
             VALUES ('$name', '$rollno', '$class', '$report_type', '$report_details', '$teacher_email')";
 
     if (mysqli_query($conn, $sql)) {
          echo "<script>alert('Report recorded Stored successfully!');</script>";
     } else {
         echo "Error: " . $sql . "<br>" . $conn->error;
     }
 
     $conn->close(); 
} else {
     echo "Invalid Request";
}
?>
<html>
<head>
     <title>Student Report</title>
     <script>
          function showReportOptions() {
               var reportType = document.getElementById("report_type").value;
               var reportInputDiv = document.getElementById("report_input");
               var reportSelect = document.getElementById("report_details");

               reportSelect.innerHTML = "";

               var options = [];

               if (reportType === "Attendance Report") {
                    options = ["Present", "Absent", "Late"];
               } else if (reportType === "Behavior Report") {
                    options = ["Excellent", "Good", "Needs Improvement", "Poor"];
               } else if (reportType === "Exam Report") {
                    options = ["Passed", "Failed", "Needs Retake"];
               } else if (reportType === "Leave Report") {
                    options = ["Sick Leave", "Casual Leave", "Emergency Leave", "Other"];
               } else {
                    reportInputDiv.style.display = "none";
                    return;
               }

               options.forEach(function(optionText) {
                    var option = document.createElement("option");
                    option.value = optionText;
                    option.text = optionText;
                    reportSelect.appendChild(option);
               });

               reportInputDiv.style.display = "block";
          }
     </script>
     <style>
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
               gap: 70px;
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

          body {
               font-family: Arial, sans-serif;
               background-color: #f4f4f4;
               overflow: hidden; 
               margin: 0;
               padding: 0;
          }

          .container {
               width: 40%;
               margin: 78px auto;
               background: white;
               padding: 20px;
               box-shadow: 0px 0px 10px gray;
               border-radius: 8px; 
          }

          h2 {
               text-align: center;
               color: #333;
          }

          form {
               display: flex;
               flex-direction: column;
          }

          label {
               font-weight: bold;
               margin-top: 10px;
          }

          input, select {
               width: 100%; 
               padding: 10px;
               margin-top: 5px;
               border: 1px solid #ccc;
               border-radius: 5px;
          }

          #report_input {
               display: none; 
               margin-top: 10px; 
          }

          #report_input input {
               width: 100%; 
          }

          button {
               margin-top: 20px;
               padding: 10px;
               background: #28a745;
               color: white;
               border: none;
               border-radius: 5px;
               cursor: pointer;
          }

          button:hover {
               background: #218838;
          }
     </style>
</head>
<body>
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
          <h2>Student Report</h2>
          <form method="post">
               <label for="name">Student Name:</label>
               <input type="text" id="name" name="name" required>

               <label for="rollno">Roll Number:</label>
               <input type="text" id="rollno" name="rollno" required>

               <label for="class">Class:</label>
               <input type="text" id="class" name="class" required>

               <label for="report_type">Report Type:</label>
               <select id="report_type" name="report_type" required onchange="showReportOptions()">
                    <option value="">Select Report Type</option>
                    <option value="Exam Report">Exam Report</option>
                    <option value="Attendance Report">Attendance Report</option>
                    <option value="Leave Report">Leave Report</option>
                    <option value="Behavior Report">Behavior Report</option>
               </select>

               <div id="report_input">
                    <label for="report_details">Enter Report Details:</label>
                    <select id="report_details" name="report_details"></select>
               </div>

               <button type="submit">Submit Report</button>
          </form>
     </div>
</body>
</html>