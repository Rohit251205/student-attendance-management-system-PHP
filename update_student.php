<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "attendance_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}

$teacher_email = $_SESSION['email']; 

$check_teacher_sql = "SELECT * FROM users WHERE email = '$teacher_email'";
$check_teacher_result = mysqli_query($conn, $check_teacher_sql);

if (mysqli_num_rows($check_teacher_result) == 0) {
    session_destroy();
    header("Location: Login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $student_rollno = mysqli_real_escape_string($conn, $_POST['student_rollno']);
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $student_class = mysqli_real_escape_string($conn, $_POST['student_class']);
    $student_date = mysqli_real_escape_string($conn, $_POST['student_date']);
    $student_attendance = mysqli_real_escape_string($conn, $_POST['student_attendance']);

    $check_student_sql = "SELECT * FROM students WHERE stu_rno = '$student_rollno' AND fact_email = '$teacher_email'";
    $check_student_result = mysqli_query($conn, $check_student_sql);

    if (mysqli_num_rows($check_student_result) > 0) {
        $sql = "UPDATE attendance SET 
                    stu_rno = '$student_rollno', 
                    stu_name = '$student_name', 
                    class = '$student_class', 
                    date = '$student_date', 
                    attendance = '$student_attendance' 
                WHERE id = '$student_id'";

        if (mysqli_query($conn, $sql)) {
            $update_student_sql = "UPDATE students SET class = '$student_class' 
                                   WHERE stu_rno = '$student_rollno' AND fact_email = '$teacher_email'";

            if (mysqli_query($conn, $update_student_sql)) {
                echo "<script>alert('Student updated successfully!'); window.location.href = 'manage_student.php';</script>";
            } else {
                echo "<h3 style='color:red;'>Error updating student class: " . mysqli_error($conn) . "</h3>";
            }
        } else {
            echo "<h3 style='color:red;'>Error updating attendance: " . mysqli_error($conn) . "</h3>";
        }
    } else {
        echo "<h3 style='color:red;'>Student not found or not assigned to this teacher.</h3>";
    }
} else {
    echo "<h3 style='color:red;'>Invalid request.</h3>";
}

mysqli_close($conn);
?>