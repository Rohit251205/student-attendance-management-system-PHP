<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "attendance_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the teacher is logged in
if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}

$teacher_email = $_SESSION['email'];

// Verify if the logged-in teacher exists in the users table
$teacher_check_sql = "SELECT * FROM users WHERE email = '$teacher_email'";
$teacher_check_result = mysqli_query($conn, $teacher_check_sql);
if (mysqli_num_rows($teacher_check_result) == 0) {
    session_destroy();
    header("Location: Login.php");
    exit();
}

// Handle form submission for adding a student 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rno = $_POST['rno'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $email = $_POST['email'];
    
    // Ensure teacher still exists before adding the student
    $teacher_check = "SELECT * FROM users WHERE email = '$teacher_email'";
    $teacher_result = mysqli_query($conn, $teacher_check);
    if (mysqli_num_rows($teacher_result) == 0) {
        echo "<script>alert('Error: Your account no longer exists! Please log in again.'); window.location.href = 'Login.php';</script>";
        exit();
    }

    // Check if the student already exists for the same teacher
    $check_sql = "SELECT * FROM students WHERE stu_rno = '$rno' AND fact_email = '$teacher_email'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Student already exists under your records!');</script>";
    } else {
        // Insert student with teacher's email in fact_email column
        $query = "INSERT INTO students (stu_rno, stu_name, class, email, fact_email) 
                  VALUES ('$rno', '$name', '$class', '$email', '$teacher_email')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Student added successfully!'); window.location.href = 'manage_student.php';</script>";
        } else {
            echo "<script>alert('Error adding student: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Fetch only students assigned to this teacher
$sql = "SELECT * FROM students WHERE fact_email = '$teacher_email'";
$result = mysqli_query($conn, $sql);
?>


<html>
<head>
     <title>Manage Students</title>
     <style>
          * {
               padding: 0;
               margin: 0;
               box-sizing: border-box;
          }

          body {
               font-family: Arial, sans-serif;
               background-color: #f9f9f9;
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

          h1 {
               text-align: center;
               color: #2c3e50;
               margin-top: 100px;
               margin-bottom: 20px;
          }

          .main-content {
               display: flex;
               justify-content: space-between;
               gap: 20px;
               padding: 20px;
          }

          .form-section, .table-section {
               flex: 1;
               padding: 20px;
               background: #ffffff;
               border-radius: 8px;
               box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          }

          h2 {
               text-align: center;
               color: #2c3e50;
               margin-bottom: 20px;
          }

          form, table {
               width: 100%;
          }

          table {
               border-collapse: collapse;
               margin-top: 20px;
          }

          table, th, td {
               border: 1px solid #ddd;
          }

          th, td {
               padding: 10px;
               text-align: center;
          }

          th {
               background-color: #f4f4f4;
               color: #2c3e50;
          }

          .form-group {
               margin: 15px 0;
          }

          .form-group label {
               display: block;
               margin-bottom: 5px;
               font-weight: bold;
          }

          .form-group input, .form-group select {
               width: 100%;
               padding: 10px;
               border: 1px solid #ddd;
               border-radius: 4px;
          }

          .button {
               display: inline-block;
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
          
          .actions button {
               margin: 0 5px;
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
    
     <h1>Manage Students</h1>

     <div class="main-content">
          <div class="form-section">
               <h2>Add New Student</h2>
               <form method="POST">
                    <div class="form-group">
                         <label for="Student-rollno">Student Roll No:</label>
                         <input type="text" id="Student-rollno" name="rno" required>
                    </div>
                    <div class="form-group">
                         <label for="Student-name">Student Name:</label>
                         <input type="text" id="Student-name" name="name" required>
                    </div>
                    <div class="form-group">
                         <label for="Student-class">Student Class:</label>
                         <input type="text" id="Student-class" name="class" required>
                    </div>
                    <div class="form-group">
                         <label for="Student-email">Email:</label>
                         <input type="email" id="Student-email" name="email" required>
                    </div>
                    <input type="hidden" name="fact_email" value="<?php echo $teacher_email; ?>">
                    <button type="submit" class="button">Add Student</button>
               </form>
          </div>

          <div class="table-section">
               <h2>Existing Students</h2>
               <table>
                    <tr>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <td><?php echo $row['stu_rno']; ?></td>
                        <td><?php echo $row['stu_name']; ?></td>
                        <td><?php echo $row['class']; ?></td>
                        <td><?php echo isset($row['email']) ? $row['email'] : 'N/A'; ?></td>
                        <td class="actions">
                            <form action="update_std.php" method="POST" style="display:inline;">
                                <input type="hidden" name="student_id" value="<?php echo $row['stu_rno']; ?>">
                                <button type="submit" class="button">Edit</button>
                            </form>
                            <form action="delete_std.php" method="POST" style="display:inline;">
                                <input type="hidden" name="student_id" value="<?php echo $row['stu_rno']; ?>">
                                <button type="submit" class="button" style="background-color: #e74c3c;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
               </table>
          </div>
     </div>
</body>
</html>