<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Footer</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
  margin:0;
  font-family: Arial, sans-serif;
}

.main-footer{
  background:#000;
  color:#fff;
  padding:50px 0 0 0;
}

/* FORCE SIDE BY SIDE */
.footer-row{
  display:flex;
  justify-content:space-between;
  gap:40px;
}

.footer-col{
  width:33%;
}

.main-footer h5{
  margin-bottom:15px;
  font-weight:600;
}

.main-footer p{
  color:#ccc;
  font-size:14px;
  line-height:1.6;
}

.footer-links{
  list-style:none;
  padding:0;
}

.footer-links li{
  margin-bottom:8px;
}

.footer-links a{
  color:#1e90ff;
  text-decoration:none;
  font-size:14px;
}

.footer-links a:hover{
  color:#fff;
  text-decoration:underline;
}

.footer-bottom{
  background:#111;
  text-align:center;
  padding:15px 0;
  margin-top:20px;
  font-size:13px;
  color:#ccc;
  border-top:1px solid #333;
}

/* Mobile me bhi side me hi rahe */
@media(max-width:768px){
  .footer-row{
    flex-direction:row;
  }
}
</style>

</head>
<body>

<footer class="main-footer">
  <div class="container">
    <div class="footer-row">

      <!-- ABOUT -->
      <div class="footer-col">
        <h5>About Us</h5>
        <p>
          Government Girls Polytechnic (GGP), Amethi was established in 1986.
          The college is approved by the All India Council of Technical Education (AICTE).
          The college is affiliated to the Board of Technical Education, Uttar Pradesh.
          The institute's infrastructure is modern with well equipped facilities.
          A variety of teaching and learning techniques are employed to impart knowledge
          and skills to the students in various departments of the college.
        </p>
      </div>

      <!-- NAVIGATION -->
      <div class="footer-col">
        <h5>Navigation</h5>
        <ul class="footer-links">
          <li><a href="#">Admin Login</a></li>
          <li><a href="#">Home</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Campus Map</a></li>
          <li><a href="#">Feedback</a></li>
          <li><a href="#">Anti Ragging Complaints</a></li>
        </ul>
      </div>

      <!-- IMPORTANT LINKS -->
      <div class="footer-col">
        <h5>Important Links</h5>
        <ul class="footer-links">
          <li><a href="#">Vidya Lakshmi Education Portal</a></li>
          <li><a href="#">Department of Technical Education</a></li>
          <li><a href="#">Joint Entrance Examination (JEEC) Polytechnic</a></li>
          <li><a href="#">Board of Technical Education (Official Website)</a></li>
          <li><a href="#">Board of Technical Education (Official Website for Result)</a></li>
          <li><a href="#">Official Website Of Amethi</a></li>
        </ul>
      </div>

    </div>
  </div>

  <div class="footer-bottom">
    © 2026 Government Girls Polytechnic, Amethi | All Rights Reserved
  </div>

</footer>

</body>                                 
</html>