<?php
$conn = mysqli_connect("localhost", "root", "", "attendance_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);

     $sql = "DELETE FROM teachers WHERE id = '$faculty_id'";

     if (mysqli_query($conn, $sql)) {
          echo "<script>alert('Faculty delete successfully!');</script>";
          header("Location: manage_faculty.php");
     } else {
          echo "Error deleting record: " . mysqli_error($conn);
     }
}

mysqli_close($conn);
?>