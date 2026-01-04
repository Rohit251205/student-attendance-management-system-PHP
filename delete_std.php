<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "attendance_db") or die("Connection failed");

// Check if student_id is provided
if (!empty($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $delete_query = "DELETE FROM students WHERE stu_rno = '$student_id' LIMIT 1";

    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Student deleted successfully!'); window.location='manage_student.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location='manage_student.php';</script>";
    }
} else {
    echo "<script>alert('Invalid Request!'); window.location='manage_student.php';</script>";
}

mysqli_close($conn);
?>