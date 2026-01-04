<?php
session_start();

// Database Connection
$con = mysqli_connect("localhost", "root", "", "attendance_db");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user details
    $sql = "SELECT id, email, password FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify password (Plaintext for now, but should be hashed)
        if ($password === $row['password']) {  
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            echo "<script>
                    alert('Login successful!');
                    window.location.href = 'Navbar.php';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Invalid email or password.');</script>";
        }
    } else {
        echo "<script>alert('User not found Please Sign Up.');
                window.location.href = 'signup.php';
                </script>";
    }
}

// Close connection
mysqli_close($con);
?>

<html>
<head>
    <title>Login</title>
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
        }
    </style>
</head>
<body>
    <div class="con">
        <form action="Login.php" method="post"> <!-- Fixed action -->
            <h2>Login</h2>
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        <p>Admin Login? <a href="adminlogin.php">Login</a></p>
    </div>
</body>
</html>
