<?php
session_start();

if (!isset($_SESSION['email'])) {
     header("Location: Login.php");
     exit();
}
?>

<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <title>Contact Us</title>
     <style>
          * {
               margin: 0;
               padding: 0;
               box-sizing: border-box;
               font-family: Arial, sans-serif;
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

          body {
            background-color: #f4f4f4;
            padding-top: 80px; 
          }

          .container {
               width: 50%;
               margin: 50px auto;
               background: white;
               padding: 30px;
               border-radius: 10px;
               box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
               text-align: center;
          }

          .container h2 {
               font-size: 28px;
               font-weight: bold;
               color: #333;
               margin-bottom: 20px;
          }

          .contact p {
               font-size: 18px;
               line-height: 1.8;
               color: #555;
               margin: 5px 0;
          }

          .contact a {
               color: #007bff;
               text-decoration: none;
          }

          .contact a:hover {
               text-decoration: underline;
          }

          .social-links {
               display: flex;
               justify-content: center;
               gap: 15px;
               margin-top: 20px;
          }

          .social-icon {
               display: flex;
               align-items: center;
               justify-content: center;
               width: 50px;
               height: 50px;
               border-radius: 50%;
               text-decoration: none;
               font-size: 22px;
          }

          .social-icon:nth-child(1) {
               background: #1877F2;
               color: white;
          }

          .social-icon:nth-child(1):hover {
               background: #0f65d3;
          }

          .social-icon:nth-child(2) {
               background: #1DA1F2;
               color: white;
          }

          .social-icon:nth-child(2):hover {
               background: #0d8bda;
          }

          .social-icon:nth-child(3) {
               background: #0077b5;
               color: white;
          }

          .social-icon:nth-child(3):hover {
               background: #005582;
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

          <div class="container">
          <section class="contact">
               <h2>Contact Us</h2>
               <p><strong>Company:</strong> TechNova Solutions Pvt. Ltd.</p>
               <p><strong>Address:</strong> 123 Innovation Street, Silicon Valley, CA 94043</p>
               <p><strong>Phone:</strong> +1 (800) 123-4567</p>
               <p><strong>Email:</strong> <a href="mailto:support@technova.com">support@technova.com</a></p>
               <p><strong>Support:</strong> Mon - Fri (9:00 AM - 6:00 PM)</p>
               <p><strong>Website:</strong> <a href="https://www.technova.com" target="_blank">www.technova.com</a></p>

               <div class="social-links">
                    <a href="https://www.facebook.com" target="_blank" class="social-icon">
                         <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.twitter.com" target="_blank" class="social-icon">
                         <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com" target="_blank" class="social-icon">
                         <i class="fab fa-linkedin-in"></i>
                    </a>
               </div>
          </section>
     </div>
</body>
</html>