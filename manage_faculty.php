<?php
$conn = mysqli_connect("localhost", "root", "", "attendance_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = "";
$name = "";
$education = "";
$department = "";
$email = "";
$button_text = "Add Faculty";

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $query = "SELECT * FROM teachers WHERE id = '$edit_id'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $education = $row['education'];
        $department = $row['department'];
        $email = $row['email'];
        $button_text = "Update Faculty";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $education = $_POST['education'];
    $department = $_POST['department'];
    $email = $_POST['email'];

    if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
        // Update faculty record
        $update_id = $_POST['update_id'];
        $query = "UPDATE teachers SET name='$name', education='$education', department='$department', email='$email' WHERE id='$update_id'";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Faculty updated successfully!'); window.location='manage_faculty.php';</script>";
        }
    } else {
        // Insert new faculty record
        $query = "INSERT INTO teachers (id, name, education, department, email) VALUES ('$id', '$name', '$education', '$department', '$email')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Faculty added successfully!'); window.location='manage_faculty.php';</script>";
        }
    }
}
?>

<html>
<head>
    <title>Manage Faculty</title>
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

            h1 {
                text-align: center;
                color: #2c3e50;
                margin-top: 100px;
                margin-bottom: 20px;
            }

            .main-content {
                display: flex;
                justify-content: space-between;
                gap: 10px;
                padding: 20px;
            }

            .form-section {
                width: 25%;
                padding: 20px;
                background: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .table-section {
                width: 75%;
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

            .form-group, .form-groupbox {
                margin: 15px 0;
            }

            .form-group label, .form-groupbox label {
                display: block;
                margin-bottom: 5px;
            }

            .form-group input, .form-groupbox input {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            .form-groupbox input {
                height: 70px;
            }

            .button {
                display: inline-block;
                padding: 10px 20px;
                width: 80px;
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

            label{
                font-weight: bold;
            }

            #btn{
                width: 140px;
            }

            .actions{
                width: 220px;
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

<h1>Manage Faculty</h1>

<div class="main-content">
    <div class="form-section">
        <h2><?php echo ($button_text == "Update Faculty") ? "Edit Faculty" : "Add New Faculty"; ?></h2>
        <form action="manage_faculty.php" method="POST">
            <input type="hidden" name="update_id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="faculty-id">Faculty ID:</label>
                <input type="text" id="faculty-id" name="id" value="<?php echo $id; ?>" required <?php if ($button_text == "Update Faculty") echo "readonly"; ?>>
            </div>
            <div class="form-group">
                <label for="faculty-name">Faculty Name:</label>
                <input type="text" id="faculty-name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="education">Education:</label>
                <input type="text" id="education" name="education" value="<?php echo $education; ?>" required>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" value="<?php echo $department; ?>" required>
            </div>
            <div class="form-group">
                <label for="faculty-email">Email:</label>
                <input type="email" id="faculty-email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <button type="submit" class="button" id="btn"><?php echo $button_text; ?></button>
        </form>
    </div>

    <div class="table-section">
        <h2>Existing Faculty</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Education</th>
                <th>Department</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM teachers";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['education']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td class="actions">
                        <a href="manage_faculty.php?edit_id=<?php echo $row['id']; ?>" class="button">Edit</a>
                        <form action="delete_faculty.php" method="POST" style="display:inline;">
                            <input type="hidden" name="faculty_id" value="<?php echo $row['id']; ?>">
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