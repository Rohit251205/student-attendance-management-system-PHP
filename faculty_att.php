<?php
$conn = mysqli_connect("localhost", "root", "", "attendance_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define public holidays manually as a PHP array
$holidays = ['2025-01-01', '2025-07-04', '2025-12-25']; // New Year, Independence Day, Christmas

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['att'])) {
     $date = $_POST['date'];
     $dayOfWeek = date('N', strtotime($date)); // 1 = Monday, 7 = Sunday

     // Restrict weekends
     if ($dayOfWeek >= 6) { // 6 = Saturday, 7 = Sunday
          echo "<script>alert('Attendance cannot be marked on weekends. Please select a working day.');</script>";
          exit;
     }

     // Restrict public holidays
     if (in_array($date, $holidays)) {
          echo "<script>alert('Attendance cannot be marked on a public holiday. Please select a working day.');</script>";
          exit;
     }

     // Process attendance
     $attendance = $_POST['att'];
     foreach ($attendance as $faculty_id => $status) {
          $faculty_query = "SELECT name FROM teachers WHERE id = '$faculty_id'";
          $faculty_result = mysqli_query($conn, $faculty_query);

          if ($faculty_result && mysqli_num_rows($faculty_result) > 0) {
               $faculty_row = mysqli_fetch_assoc($faculty_result);
               $faculty_name = $faculty_row['name'];

               $query = "INSERT INTO faculties (id, name, date, attendance) 
                         VALUES ('$faculty_id', '$faculty_name', '$date', '$status')
                         ON DUPLICATE KEY UPDATE attendance='$status'";

               mysqli_query($conn, $query);
          }
     }

     echo "<script>alert('Attendance recorded successfully!');</script>";
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

               // Define public holidays in JavaScript (manually added)
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
               justify-content: right;
               width: 100%;
               gap: 200px;
          }

          .inputgroup{
               position: relative;
          }

          .inputgroup input{
               width: 300px;
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
                    <a href="dashboard.php">Dashboard</a>                        
                    <a href="faculty_att.php">Faculty Attendance</a>            
                    <a href="view_faculty_att.php">View Faculty Att.</a>
                    <a href="stu_att.php">View Student Att.</a>
                    <a href="report_std.php">Student Report</a>
                    <a href="manage_faculty.php">Manage Faculty</a> 
                    <a href="adminlogin.php">Logout</a>
               </div>
          </header>
		<div class = "con">
               <form id="attendanceForm" method = "POST">
                    <h1>Mark Attendance</h1>
                    <hr>
                    <div class="arrange">
                         <div class="inputgroup margin">
                              <input type = "date" id = "txtdate" name="date" required>
                              <label for = "txtdate" id="lbldate">Date</label>
                         </div>
                    </div>

                    <table border=1>
                         <tr>
                              <th class="rno">ID</th>
                              <th>Faculty Name</th>
                              <th>Faculty Department</th>
                              <th class="att">Attendance</th>
                         </tr>
                         <?php
                              $faculty_query = "SELECT id, name, department FROM teachers";
                              $faculty_result = mysqli_query($conn, $faculty_query);
                               
                              if ($faculty_result && mysqli_num_rows($faculty_result) > 0) {
                                   while ($row = mysqli_fetch_assoc($faculty_result)) { 
                         ?>
                         <tr>
                              <th><?php echo $row['id']; ?></th> 
                              <th><?php echo $row['name']; ?></th>
                              <th><?php echo $row['department']; ?></th>
                              <th>
                                   <div class="form-group">
                                        <input type="radio" name="att[<?php echo $row['id']; ?>]" value="Present" requied>
                                        <label>Present</label>
                                        <input type="radio" name="att[<?php echo $row['id']; ?>]" value="Absent" requied>
                                        <label>Absent</label>
                                   </div>
                              </th>
                         </tr>
                    <?php
                         } }
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