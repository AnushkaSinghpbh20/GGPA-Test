<?php
session_start();
include "../db.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/* ================= SAFE POST ================= */
function post($k){
    return (isset($_POST[$k]) && $_POST[$k] !== '') ? trim($_POST[$k]) : null;
}

/* ================= LOGIC FUNCTIONS ================= */     
function rating($t){
    switch(strtolower($t)){
        case 'excellent': return 5;
        case 'very good': return 4;
        case 'good': return 3;
        case 'average': return 2;
        case 'poor': return 1;
        default: return 0;
    }
}

function projectStatus($t){
    $n = (int) filter_var($t, FILTER_SANITIZE_NUMBER_INT);
    if($n == 100) return 5;
    if($n >= 76) return 4;
    if($n >= 51) return 3;
    if($n >= 26) return 2;
    return 1;
}

function locEase($t){
    switch(strtolower($t)){
        case 'easy to find': return 4;
        case 'average': return 3;
        case 'difficult to find': return 2;
        case 'too far': return 1;
        default: return null;
    }
}

/* ================= BASIC DATA ================= */

$name   = post('name');
$enroll = post('enrollment_no');
$branch = post('branch');

$session     = post('current_year');
$company_id  = (int) post('company_id');
$project     = post('project_name');
$start       = post('start_date');
$end         = post('end_date');
$location    = post('location');
$fees        = post('fees_submitted');
$mode        = post('training_mode');

$overall_exp = rating(post('overall_exp'));
$remark      = post('remark');

mysqli_begin_transaction($conn);

try{

/* =====================================================    
   1️⃣ training_dts (timestamp added)
===================================================== */

$sql1 = "
INSERT INTO training_dts
(timestamp,name,enroll_no,branch,session,company_id,project_name,start_dt,end_dt,
location,fees,training_mode,overall_exp,remark)
VALUES (NOW(),?,?,?,?,?,?,?,?,?,?,?,?,?)
";

$stmt1 = mysqli_prepare($conn,$sql1);

mysqli_stmt_bind_param(
$stmt1,
"ssssissssssss",
$name,
$enroll,
$branch,
$session,
$company_id,
$project,
$start,
$end,
$location,
$fees,
$mode,
$overall_exp,
$remark
);

mysqli_stmt_execute($stmt1);

$survey_id = mysqli_insert_id($conn);

/* =====================================================
   2️⃣ student_tech_map
===================================================== */

if(!empty($_POST['technology'])){

$stmt2 = mysqli_prepare(
$conn,
"INSERT INTO student_tech_map (survey_id,tech_id) VALUES (?,?)"
);

foreach($_POST['technology'] as $tid){

$tid = (int)$tid;

mysqli_stmt_bind_param($stmt2,"ii",$survey_id,$tid);
mysqli_stmt_execute($stmt2);

}

}

/* =====================================================
   3️⃣ student_trainer_map
===================================================== */
$trainer_id = post('trainer_id');
$trainer_custom = post('trainer_custom');

if($trainer_id){

$stmt3 = mysqli_prepare(
$conn,
"INSERT INTO student_trainer_map (survey_id,trainer_id) VALUES (?,?)"
);

mysqli_stmt_bind_param($stmt3,"ii",$survey_id,$trainer_id);
mysqli_stmt_execute($stmt3);

}

/* If custom trainer entered */

elseif($trainer_custom){

$stmt3 = mysqli_prepare(
$conn,
"INSERT INTO trainer_dts (name) VALUES (?)"
);

mysqli_stmt_bind_param($stmt3,"s",$trainer_custom);
mysqli_stmt_execute($stmt3);

$new_trainer_id = mysqli_insert_id($conn);

$stmt4 = mysqli_prepare(
$conn,
"INSERT INTO student_trainer_map (survey_id,trainer_id) VALUES (?,?)"
);

mysqli_stmt_bind_param($stmt4,"ii",$survey_id,$new_trainer_id);
mysqli_stmt_execute($stmt4);

}
/* =====================================================
   4️⃣ comp_feedback
===================================================== */

$communication   = rating(post('communication'));
$infrastructure  = rating(post('infrastructure'));
$activity        = post('extra_activities') == 'Yes' ? 1 : 0;
$overall_company = rating(post('company_experience'));
$company_remark  = post('company_remark');
$proj_status     = projectStatus(post('project_status'));

$stmt4 = mysqli_prepare(
$conn,
"INSERT INTO comp_feedback
(survey_id,company_id,communication,infra,activity,overall_fdb,remark,proj_status)
VALUES (?,?,?,?,?,?,?,?)"
);

mysqli_stmt_bind_param(
$stmt4,
"iiiisisi",
$survey_id,
$company_id,
$communication,
$infrastructure,
$activity,
$overall_company,
$company_remark,
$proj_status
);

mysqli_stmt_execute($stmt4);

/* =====================================================
   5️⃣ trainer_feedback
===================================================== */

$teach   = rating(post('trainer_style'));
$know    = rating(post('trainer_knowledge'));
$overall = rating(post('trainer_experience'));
$t_rem   = post('trainer_remark');

$stmt5 = mysqli_prepare(
$conn,
"INSERT INTO trainer_feedback
(survey_id,trainer_id,company_id,teaching,knowledge,overall_fdb,remark)
VALUES (?,?,?,?,?,?,?)"
);

mysqli_stmt_bind_param(
$stmt5,
"iiiiiis",
$survey_id,
$trainer_id,
$company_id,
$teach,
$know,
$overall,
$t_rem
);

mysqli_stmt_execute($stmt5);

/* =====================================================
   6️⃣ other_feedback
===================================================== */

$loc  = locEase(post('location_ease'));
$acc  = post('accommodation');
$food = post('food_facility');

$stmt6 = mysqli_prepare(
$conn,
"INSERT INTO other_feedback
(survey_id,location,accommodation,fooding)
VALUES (?,?,?,?)"
);

mysqli_stmt_bind_param(
$stmt6,
"iiss",
$survey_id,
$loc,
$acc,
$food
);

mysqli_stmt_execute($stmt6);

/* ================= COMMIT ================= */

mysqli_commit($conn);

echo "<script>
alert('Review Submitted Successfully');
window.history.back();
</script>";

/* =====================================================
   7️⃣ survey_tracker
===================================================== */

$activeSession = $_SESSION['active_session'] ?? null;

if($activeSession){

$status = "Form Submitted";

$stmt7 = mysqli_prepare(
$conn,
"INSERT INTO survey_tracker
(survey_id,enrollment_no,session_value,status)
VALUES (?,?,?,?)"
);

mysqli_stmt_bind_param(
$stmt7,
"isss",
$survey_id,
$enroll,
$activeSession,
$status
);

mysqli_stmt_execute($stmt7);

          
   


}

}catch(Exception $e){

mysqli_rollback($conn);

echo "<script>
alert('Error: ".$e->getMessage()."');


</script>";
   header('students_dashboard.php');
}

?>