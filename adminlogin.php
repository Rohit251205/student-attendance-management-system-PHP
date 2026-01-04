<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check for hardcoded admin credentials
    if ($username === "admin" && $password === "admin123") {
        $_SESSION['admin_username'] = $username;

        echo "<script>
                alert('Admin login successful!');
                window.location.href = 'dashboard.php';
              </script>";
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
    }
}
?>

<html>
<head>
     <title>Admin Login</title>
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
          <form method="post">
               <h2>Admin Login</h2>
               <label for="username">Username</label>
               <input type="text" id="username" name="username" required>
               <label for="password">Password</label>
               <input type="password" id="password" name="password" required>
               <button type="submit" name="login">Login</button>
          </form>
          <p>Already have an account? <a href="login.php">Login</a></p>
     </div>
</body>
</html>