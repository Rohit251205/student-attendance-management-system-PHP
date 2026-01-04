<?php

$conn = mysqli_connect("localhost", "root", "", "attendance_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
     $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

     if (empty($student_id)) {
          die("Error: No student ID received.");
     }

     $sql = "SELECT * FROM attendance WHERE stu_rno = '$student_id'";
     $result = mysqli_query($conn, $sql);

     if ($row = mysqli_fetch_assoc($result)) {
     } 
     else {
          echo "<script>alert('Student Not Found Because Attendance Record not Stored!');
                         window.location.href = 'manage_student.php';
               </script>"; 
     }
} 
else {
     echo "<script>alert('Invalid Request!');
                    window.location.href = 'manage_student.php'; 
          </script>";
}

mysqli_close($conn);
?>

<html>
     <head>
          <title>Update Student</title>
          <style>
               body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    font-family: Arial, sans-serif;
                    padding: 20px;
                    background-color: #f9f9f9;
                    overflow: hidden;
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

               .form-section {
                    background: #ffffff;
                    width: 50%;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    margin: auto; 
                    margin-top: 55px;
               }

               .form-group {
                    margin-bottom: 15px;
               }

               .form-group label {
                    display: block;
                    margin-bottom: 5px;
               }

               .form-group input {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
               }

               .button {
                    padding: 10px 20px;
                    background-color: #3498db;
                    color: white;
                    text-decoration: none;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
               }

               .button:hover {
                    background-color: #2980b9;
               }

               #student-attendance {
                    width: 130px;
                    height: 40px;
                    padding: 5px;
                    border: 2px solid #3498db;
                    border-radius: 4px;
                    background-color: #fff;
                    font-size: 16px;
                    font-weight: bold;
                    cursor: pointer;
                    outline: none;
                    transition: all 0.3s ease-in-out;
               }

               #student-attendance:hover {
                    border-color: #2980b9;
               }

               #student-attendance:focus {
                    border-color: #2980b9;
                    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
               }

               #student-attendance option {
                    font-weight: bold;
                    font-size: 16px;
                    padding: 10px;
                    background-color: #ffffff;
                    color: #333;
               }

               #student-attendance option:hover {
                    background-color: #3498db;
                    color: #fff;
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
          <div class="form-section">
               <h2>Update Student</h2>
               <form action="update_student.php" method="POST">
                    <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">

                    <div class="form-group">
                         <label for="Student-photo">Student Rollno:</label>
                         <input type="text" id="Student-rollno" name="student_rollno" value="<?php echo isset($row['stu_rno']) ? $row['stu_rno'] : '' ?>" required>
                    </div>

                    <div class="form-group">
                         <label for="package-name">Student Name:</label>
                         <input type="text" id="student-name" name="student_name" value="<?php echo isset($row['stu_name']) ? $row['stu_name'] : '' ?>" required>
                    </div>

                    <div class="form-group">
                         <label for="Student-price">Student Class:</label>
                         <input type="text" id="Student-class" name="student_class" value="<?php echo isset($row['class']) ? $row['class'] : '' ?>" required>
                    </div>

                    <div class="form-group">
                         <label for="Student-type">Student Date:</label>
                         <input type="date" id="Student-date" name="student_date" value="<?php echo isset($row['date']) ? $row['date'] : '' ?>" required>
                    </div>

                    <div class="form-group">
                         <label for="student-attendance">Attendance:</label>
                         <select id="student-attendance" name="student_attendance" required>
                              <option value="Present" <?php echo (isset($row['attendance']) && $row['attendance'] == 'Present') ? 'selected' : ''; ?>>Present</option>
                              <option value="Absent" <?php echo (isset($row['attendance']) && $row['attendance'] == 'Absent') ? 'selected' : ''; ?>>Absent</option>
                         </select>
                    </div>
                    <button type="submit" class="button">Update Student</button>
               </form>
          </div>
     </body>
</html>