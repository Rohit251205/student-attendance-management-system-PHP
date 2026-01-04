<div class="layout">
               <p>
                    <img src="img.jpeg">
                    Mr. Mayur M. Patel<br>
                    COORDINATOR - B.SC CA&IT,B.SC AIML,BCA<br>
                    ASSISTANT PROFESSOR<br>
                    EDU. M.C.A.,PH.D (PURSUING)<br>
                    WEB BASED PROGRAMMING (ASP,XML,HTML)<br>
                    E-MAIL : mayur@nvpas.edu.in<br>
               </p>
          </div>
          <div class="layout">
               <p>
                    <img src="img2.jpeg">
                    Dr. Monika Patel<br>
                    ASSISTANT PROFESSOR<br>
                    EDU. M.C.A.,M.PHIL(CS),PH.D. ADFS<br>
                    COMPUTER NETWORK<br>
                    E-MAIL : monika@nvpas.edu.in<br>
               </p>
          </div>
          <div class="layout">
               <p>
                   <img src="img3.jpeg">
                   Ms. Mamta Megha<br>
                   ASSISTANT PROFESSOR<br>
                   EDU. M.C.A.,PH.D. (PURSUING)<br>
                   WEB DESIGN,WEB TECHNOLOGY,<br>
                   SYSTEM ANALYSIS AND DESIGN,<br>
                   ADVANCE DATA FILE STRUCTURE<br>
                   E-MAIL : mamta.megha@nvpas.edu.in<br>
               </p>
          </div>
          <div class="layout">
               <p>
                    <img src="img6.jpeg">
                    Mr. Kartik A. Jagtap<br>
                    HEAD OF ENGLISH DEPARTMENT<br>
                    EDU. M.A.,M.PHIL.<br>
                    COMMUNICATION SKILLS,ENGLISH LANGUAGE<br>
                    TEACHING(ELT)<br>
                    E-MAIL : kartik@nvpas.edu.in<br>
               </p>
          </div>
          <div class="layout">
               <p>
                    <img src="img4.jpeg">
                    Ms. Urvisha Suthar<br>
                    ASSISTANT PROFESSOR<br>
                    EDU. M.SC(IT)<br>
                    COMPUTER GRAPHICS,ADVANCE<br> 
                    NETWORKING,MULTIMEDIA<br>
                    APPLICATION,WIRELESS COMMUNICATION<br>
                    E-MAIL : urvisha.suthar@nvpas.edu.in<br>
               </p>
          </div>
          <div class="layout">
               <p>
                    <img src="img5.jpeg">
                    Dr. Tejas H. Thakkar<br>
                    ASSISTANT PROFESSOR<br>
                    EDU. M.C.A.,PH.D.<br>
                    ARTIFICIAL INTELLIGENCE,DATA<br>
                    MINING,DATA WAREHOUSING<br>
                    CLOUD COMUTING<br>
                    E-MAIL : tejas@nvpas.edu.in<br>
               </p>
          </div>
     </div>    


     // Check if attendance is already recorded
    $check_attendance_query = "SELECT 1 FROM attendance WHERE class = '$class' AND fact_email = '$faculty_email' LIMIT 1";
    $check_attendance_result = mysqli_query($conn, $check_attendance_query);

    if (mysqli_num_rows($check_attendance_result) > 0) {
        echo "<script>alert('Attendance for this class has already been recorded.'); 
              window.location.href='attendance.php';</script>";
        exit;
    }

    this code solve my problem that is update student class show only when one time 
    old student class attendance will be mark then update student class show and also 
    mark attendance and in database 
    that particular student attendance show and that particular student old record reflect attendance