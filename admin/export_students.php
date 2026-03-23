<?php

include("../db.php");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_status.xls");

$year = $_GET['year'] ?? "";
$statusFilter = $_GET['status_filter'] ?? "";

/* ================= STATUS CONDITION ================= */

$statusCondition="";

if($statusFilter=="active"){
$statusCondition="AND u.status='Active'";
}

if($statusFilter=="registered"){
$statusCondition="AND u.enrollment_no IS NOT NULL";
}

if($statusFilter=="submitted"){
$statusCondition="AND st.enrollment_no IS NOT NULL";
}

if($statusFilter=="notsubmitted"){
$statusCondition="AND st.enrollment_no IS NULL";
}

/* ================= QUERY ================= */

$sql="

SELECT 
s.enrollment_no,
s.name,
s.dob,
s.branch,
s.addmission_year,

u.status AS user_status,

CASE 
WHEN st.enrollment_no IS NULL THEN 'Form Not Submitted'
ELSE 'Form Submitted'
END AS survey_status

FROM student_data s

LEFT JOIN users u
ON s.enrollment_no=u.enrollment_no

LEFT JOIN survey_tracker st
ON s.enrollment_no=st.enrollment_no

WHERE s.addmission_year='$year'
$statusCondition

ORDER BY s.branch,s.name

";

$res=mysqli_query($conn,$sql);

echo "<table border='1'>";

echo "

<tr>
<th>Enrollment</th>
<th>Name</th>
<th>DOB</th>
<th>Branch</th>
<th>Admission Year</th>
<th>User Status</th>
<th>Survey Status</th>
</tr>

";

while($row=mysqli_fetch_assoc($res)){

echo "

<tr>
<td>".$row['enrollment_no']."</td>
<td>".$row['name']."</td>
<td>".$row['dob']."</td>
<td>".$row['branch']."</td>
<td>".$row['addmission_year']."</td>
<td>".$row['user_status']."</td>
<td>".$row['survey_status']."</td>
</tr>

";

}

echo "</table>";

?>