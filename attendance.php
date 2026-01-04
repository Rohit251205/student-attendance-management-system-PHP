<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "attendance_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure the teacher is logged in
if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}

$faculty_email = $_SESSION['email'];

// Check if the logged-in teacher exists in `users` table
$user_check_query = "SELECT id FROM users WHERE email = '$faculty_email' LIMIT 1";
$user_check_result = mysqli_query($conn, $user_check_query);

if (!$user_check_result || mysqli_num_rows($user_check_result) == 0) {
    session_destroy();
    echo "<script>alert('Your account does not exist. Please log in again.'); 
          window.location.href='Login.php';</script>";
    exit();
}

$current_date = date('Y-m-d');

$class_query = "(SELECT DISTINCT s.class 
                FROM students s 
                LEFT JOIN attendance a ON s.class = a.class AND a.date = '$current_date'
                WHERE s.fact_email = '$faculty_email' 
                AND a.class IS NULL)
                
                UNION
                
                (SELECT DISTINCT s.class 
                FROM students s 
                WHERE s.fact_email = '$faculty_email' 
                AND NOT EXISTS (
                    SELECT 1 FROM attendance a 
                    WHERE a.class = s.class 
                    AND a.date = '$current_date'
                )
                AND s.class = (
                    SELECT MAX(class) FROM students WHERE fact_email = '$faculty_email'
                ))";

$class_result = mysqli_query($conn, $class_query);

$class = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class'])) {
    $class = $_POST['class'];

    $check_attendance_query = "SELECT 1 FROM attendance WHERE class = '$class' AND fact_email = '$faculty_email' LIMIT 1";
    $check_attendance_result = mysqli_query($conn, $check_attendance_query);

    if (mysqli_num_rows($check_attendance_result) > 0) {
        echo "<script>alert('Attendance for this class has already been marked. You cannot select it again.'); 
              window.location.href='attendance.php';</script>";
        exit;
    }
}

// Attendance submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['att'])) {
    $class = $_POST['class'];
    $attendance = $_POST['att'];
    $date = $_POST['dt'];

    // **Security check again before marking attendance**
    $check_attendance_query = "SELECT 1 FROM attendance WHERE class = '$class' AND fact_email = '$faculty_email' LIMIT 1";
    $check_attendance_result = mysqli_query($conn, $check_attendance_query);

    if (mysqli_num_rows($check_attendance_result) > 0) {
        echo "<script>alert('Attendance for this class has already been recorded.'); 
              window.location.href='attendance.php';</script>";
        exit;
    }

    // Process attendance
    foreach ($attendance as $roll_no => $status) {
        $stu_query = "SELECT stu_name FROM students WHERE stu_rno = '$roll_no' AND class = '$class' LIMIT 1";
        $stu_result = mysqli_query($conn, $stu_query);

        if ($stu_result && mysqli_num_rows($stu_result) > 0) {
            $stu_row = mysqli_fetch_assoc($stu_result);
            $stu_name = $stu_row['stu_name'];

            $query = "INSERT INTO attendance (stu_rno, stu_name, class, date, attendance, fact_email) 
                      VALUES ('$roll_no', '$stu_name', '$class', '$date', '$status', '$faculty_email')";

            mysqli_query($conn, $query);
        }
    }

    echo "<script>alert('Attendance recorded successfully!'); 
          window.location.href='attendance.php';</script>";
}
?>

<html>
	<head>
		<title>Login</title>
	</head> 
     <script>
          document.addEventListener("DOMContentLoaded", function () {
               let dateInput = document.getElementById("txtdate");
               let today = new Date().toISOString().split("T")[0];
               dateInput.setAttribute("max", today);

               // Public holidays manually added in JavaScript (same as PHP)
               let publicHolidays = [
                    '2025-01-01', // New Year
                    '2025-07-04', // Independence Day
                    '2025-12-25'  // Christmas
               ];

               dateInput.addEventListener("change", function () {
                    let selectedDate = new Date(this.value);
                    let dayOfWeek = selectedDate.getDay(); // 0 = Sunday, 6 = Saturday

                    if (dayOfWeek === 0 || dayOfWeek === 6) {
                         alert("Attendance cannot be marked on weekends. Please select a working day.");
                         this.value = "";
                         return;
                    }

                    let selectedDateString = this.value;
                    if (publicHolidays.includes(selectedDateString)) {
                         alert("Attendance cannot be marked on a public holiday. Please select a working day.");
                         this.value = "";
                    }
               });
          });
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
               display: flex;
               flex-direction: column;
               align-items: center;
               margin: 0;
          }

          .con{
               background-color: #fff;
               margin-top: 90px;
               width: 1000px;
               height: 100%;
               display: flex;
               justify-content: center;
               box-shadow: 0 0 10px rgba(0, 0, 0, 1);
               border-radius: 5px;
               transition: all 1s;
          }

          .arrange{
               display: flex;
               justify-content: center;
               align-items: center;
               width: 100%;
               gap: 200px;
          }

          .inputgroup{
               position: relative;
          }

          .inputgroup input{
               width: 500px;
               height: 60px;
               background: transparent;
               outline: none;
               border: none;
               border-bottom: 1px solid red;
               color: black;
               font-size: 20px;
               transition: all 200ms;
          }

          .inputgroup label{
               position: absolute;
               color: red;
               font-size: 20px;
               top: 0;
               left: 0;
               transform: translateY(-15px);
               transition: all 200ms;
          }

          .inputgroup input:hover +label,
          .inputgroup input:focus +label,
          .inputgroup input:valid +label
          {
               transform: translateY(-25px);
               color: rgb(0, 85, 255);
          }

          .inputgroup input:hover,
          .inputgroup input:focus,
          .inputgroup input:valid
          {
               border-bottom: 1px solid rgb(0, 85, 255);
          }

          .margin{
               margin-top: 45px;
          }

          h1{
               flex: 1;
               text-align: center;
          }

          .submit-btn{
               width: 100px;
               margin-top: 30px;
               background-color: #007bff;
               color: #fff;
               border: none;
               padding: 10px;
               border-radius: 5px;
               cursor: pointer;
          }

          hr{
               height: 2px;
               width: 400px;
               background-color: gray;  
          }

          table{
               border-color: #f4f4f4;
               margin-top: 40px;
               width: 900px;
          }

          tr,th{
               padding: 12px;
          }

          .rno{
               width: 100px;
          }

          .att{
               width: 250px;
          }

          .inputgroup select {
               width: 320px;
               height: 60px;
               background: transparent;
               outline: none;
               border: none;
               border-bottom: 1px solid red;
               color: black;
               font-size: 20px;
               transition: all 200ms;
          }

          .inputgroup select:focus {
               border-bottom: 1px solid rgb(0, 85, 255);
          }

          .inputgroup label {
               position: absolute;
               color: red;
               font-size: 20px;
               top: 0;
               left: 0;
               transform: translateY(-15px);
               transition: all 200ms;
          }

          .inputgroup select:focus + label {
               transform: translateY(-25px);
               color: rgb(0, 85, 255);
          }
     </style>

	<body>
     <div>
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
		<div class = "con">
               <form id="attendanceForm" method = "POST">
                    <h1>Mark Attendance</h1>
                    <hr>
                    <div class="arrange">
                         <div class="inputgroup margin">
                              <select name="class" onchange="this.form.submit()">
                                   <option value="">Select Class</option>
                                        <?php 
                                             mysqli_data_seek($class_result, 0);
                                             while ($row = mysqli_fetch_assoc($class_result)) { 
                                        ?>
                                        <option value="<?php echo $row['class']; ?>" 
                                             <?php if ($class == $row['class']) echo 'selected'; ?>>
                                             <?php echo $row['class']; ?>
                                        </option>
                              <?php } ?>
                              </select>
                              <label for="classSelect">Class</label>
                         </div>
                         <div class="inputgroup margin">
                              <input type = "date" id = "txtdate" name="dt" required>
                              <label for = "txtdate" id="lbldate">Date</label>
                         </div>
                    </div>

                    <table border=1>
                         <tr>
                              <th class="rno">Roll No</th>
                              <th>Student Name</th>
                              <th class="att">Attendance</th>
                         </tr>
                    <?php
                         $student_query = "SELECT stu_rno, stu_name FROM students WHERE class = '$class' AND fact_email = '$faculty_email' ORDER BY stu_rno ASC";
                         $result = mysqli_query($conn, $student_query);
                         while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                         <tr>
                              <th><?php echo $row['stu_rno']; ?></th> 
                              <th><?php echo $row['stu_name']; ?></th>
                              <th>
                                   <div class="form-group">
                                        <input type="radio" name="att[<?php echo $row['stu_rno']; ?>]" value="Present" requied>
                                        <label>Present</label>
                                        <input type="radio" name="att[<?php echo $row['stu_rno']; ?>]" value="Absent" requied>
                                        <label>Absent</label>
                                   </div>
                              </th>
                         </tr>
                    <?php
                         }
                    ?>
                    </table>

                    <button type="submit" class="submit-btn" name = "btn">Submit</button>
               </form>
		</div>
     </div>

     <?php
          mysqli_close($conn);
     ?>
	</body>
</html> 