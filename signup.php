<?php
if (isset($_POST['signup'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Database Connection
    $conn = mysqli_connect("localhost", "root", "", "attendance_db");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize input
    $email = mysqli_real_escape_string($conn, $email);

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $user_name = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($user_name) > 0) {
        echo "<script>
                alert('Email already exists. Please use a different email.');
                window.location.href = 'signup.php';
              </script>";
    } else {
        // Insert new user into the database (WITHOUT PASSWORD HASHING)
        $qry1 = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $qry1);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                alert('Signup successful. Please login.');
                window.location.href = 'Login.php';
              </script>";
        } else {
            echo "<script>
                alert('Signup failed. Please try again.');
                window.location.href = 'signup.php';
              </script>";
        }
    }

    // Close the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>



<html>
<head>
    <title>Sign Up</title>
	<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1BFFFF, #2E3192);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .con {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
            font-size: 24px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            font-size: 16px;
        }

        input:focus {
            border-color: #4caf50;
        }

        button {
            background: #4caf50;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #45a049;
        }

        p {
            margin-top: 15px;
            font-size: 14px;
            color: #333;
        }

        p a {
            color: #4caf50;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="con">
        <form action="signup.php" method="post">
            <h2>Sign Up</h2>
            <label for="username">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="signup">Sign Up</button>
        </form>
        <p>Already have an account? <a href="Login.php">Login</a></p>
    </div>
</body>
</html>