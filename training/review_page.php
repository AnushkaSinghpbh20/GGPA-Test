<?php
session_start();
include('../db.php');

/* ===== LOGIN CHECK ===== */
if (!isset($_SESSION['student_enroll'])) {
    header("Location: student_login.php");
    exit;
}

$enroll = $_SESSION['student_enroll'];
$activeSession = $_SESSION['active_session'] ?? '';

/* ===== ACTIVE SESSION CHECK ===== */
if (empty($activeSession)) {
    echo "<script>
        alert('No active session!');
        window.location='student_dashboard.php';
    </script>";
    exit;
}

/* ===== ALREADY SUBMITTED CHECK ===== */
$check = mysqli_prepare(
    $conn,
    "SELECT survey_id
     FROM survey_tracker
     WHERE enrollment_no=?
     AND session_value=?
     AND status='Form Submitted'"
);

mysqli_stmt_bind_param($check, "ss", $enroll, $activeSession);
mysqli_stmt_execute($check);
$res = mysqli_stmt_get_result($check);

if (mysqli_num_rows($res) > 0) {
    echo "<script>
        alert('You already submitted feedback!');
        window.location='student_dashboard.php';
    </script>";
    exit;
}




$company_query = "SELECT company_id, company_name, location FROM company_info";
$company_result = mysqli_query($conn, $company_query);

$tech_query = "select technology_name, tech_id from training_tech";
$technology_result = mysqli_query($conn, $tech_query);

$trainer_query = "select name, trainer_id  from trainer_dts";
$trainer_result = mysqli_query($conn, $trainer_query);

$locations_query = "select  distinct location from training_dts";
$locations_result = mysqli_query($conn, $locations_query)
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Page </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #111827;
            --muted: #475569;
            --accent: #0ea5e9;
            --border: #e2e8f0;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .review-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .review-card {
            background-color: var(--card);
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            border-top: 5px solid var(--accent);
            box-shadow: 2px 4px 50px rgba(14, 165, 233, .18);
            padding: 30px 35px;
        }

        h2 {
            text-align: center;
        }

        .review-card p {
            text-align: center;
        }

        .form-group i {
            margin-right: 6px;
            color: var(--accent);
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border-radius: 15px;
            border: 1px solid var(--border);
            border-color: var(--accent);
            outline: none;
            transition: .25s;
            box-shadow: 0 0 0 2px rgba(14, 165, 233, .15);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .radio,
        .checkbox {
            margin-bottom: 15px;
        }

        h3 {
            text-align: center;
        }

        .btn {
            padding: 12px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.35);
        }

        .btn:hover {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(14, 165, 233, 0.45);
        }

        .btn:active {
            transform: scale(0.97);
        }

        h2 span {
            color: crimson;
        }

        h2::after {
            content: '';
            width: 80px;
            height: 4px;
            background: crimson;
            display: block;
            margin: 10px auto;
            border-radius: 2px;
        }

        .section-title {
            text-align: center;
            padding: 10px;
            color: #0369a1;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .main-part {

            width: 100%;
            padding: 10px;
            border-radius: 15px;
            background: linear-gradient(135deg, #e0f2fe, #f0f9ff);
        }
    </style>
</head>

<body>
    <?php include('../header.php'); ?>
    <?php include('Subheader.php'); ?>
    <div class="review-wrapper">
        <div class="review-card">
            <div class="main-part">
                <h2><span>Student</span> Feedback Form</h2>
                <p>We value your opinion! Please take a few minutes to share your thoughts about the course/training.</p>
            </div>
            <form method="post" action="review_insert.php">

                <!-- Section 1 -->
                <div class="step">
                    <h3 class="section-title">Section 1</h3>

                    <div class="form-group">

                        <input type="hidden" name="name"
                            value="<?= $_SESSION['student_name']; ?>">
                    </div>

                    <div class="form-group">


                        <input type="hidden" name="enrollment_no"
                            value="<?= $_SESSION['student_enroll']; ?>">
                    </div>

                    <div class="form-group">

                        <input type="hidden" name="branch"
                            value="<?= $_SESSION['student_branch']; ?>">
                    </div>
                    <div class="form-group">
                        <label>1. Current Year</label>
                        <input type="radio" class="radio" name="current_year" value="Second" required> Second <br>
                        <input type="radio" class="radio" name="current_year" value="Final" required> Final <br>
                    </div>

                    <div class="form-group">
                        <label>2. Company Name</label>
                        <?php while ($row = mysqli_fetch_assoc($company_result)) { ?>
                            <input type="radio"
                                class="radio"
                                name="company_id"
                                value="<?= $row['company_id']; ?>"
                                data-location="<?= $row['location']; ?>"
                                onclick="setLocation(this)"
                                required>

                            <?= $row['company_name']; ?><br>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>3. Technology</label>
                        <?php while ($row = mysqli_fetch_assoc($technology_result)) { ?>
                            <input type="checkbox" name="technology[]" class="checkbox" value="<?= $row['tech_id']; ?>">
                            <?= $row['technology_name']; ?><br>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>4. Project Name</label>
                        <input type="text" class="form-control" name="project_name" required>
                    </div>

                    <div class="form-group">
                        <label>5. Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>6. End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>

                    <div class="form-group">
<label>7. Trainer Name</label>

<!-- Trainer Radio List -->
<?php while ($row = mysqli_fetch_assoc($trainer_result)) { ?>
    <input type="radio"
        name="trainer_id"
        value="<?= $row['trainer_id']; ?>"
        onclick="disableTextbox()">

    <?= $row['name']; ?><br>
<?php } ?>

<br>

<!-- Custom Trainer Name -->
<label>Other Trainer Name</label>
<input type="text"
       name="trainer_custom"
       id="trainerTextbox"
       class="form-control"
       placeholder="Enter trainer name"
       onkeyup="disableRadios()">

</div>

                    <div class="form-group">
<label>8. Location</label>
<input type="text" id="locationField" name="location" class="form-control" readonly required>
</div>

                    <div class="form-group">
                        <label>9. Fee Submitted</label>
                        <input type="radio" name="fees_submitted" class="radio" value="Free" required> Free <br>
                        <input type="radio" name="fees_submitted" class="radio" value="2000-3000" required> 2,000-3,000 <br>
                        <input type="radio" name="fees_submitted" class="radio" value="3000-4000" required> 3,000-4,000 <br>
                        <input type="radio" name="fees_submitted" class="radio" value="4000-5000" required> 4,000-5,000 <br>
                        <input type="radio" name="fees_submitted" class="radio" value="5000-6000" required> 5,000-6,000 <br>
                        <input type="radio" name="fees_submitted" class="radio" value="6000-7000" required> 6,000-7,000 <br>
                    </div>

                    <div class="form-group">
                        <label>10. Training Mode</label>
                        <input type="radio" name="training_mode" class="radio" value="Online" required> Online <br>
                        <input type="radio" name="training_mode" class="radio" value="Offline" required> Offline<br>
                    </div>

                    <button type="button" class="btn" onclick="nextStep()">Next Section</button>
                </div>

                <!-- Section 2 -->
                <div class="step">
                    <h3 class="section-title">Section 2</h3>
                    <h3>Company Feedback</h3>
                    <p>Please provide your feedback about company facilities.</p>

                    <div class="form-group">
                        <label>11. Communication Communication (कंपनी से आपको जो जानकारी मिली, क्या वह पर्याप्त और समय पर थी? (क्या आपको सारी ज़रूरी जानकारी जैसे ट्रेनिंग की तारीखें, जगह और काम के बारे में समय पर बताया गया था?) </label>
                        <input type="radio" name="communication" class="radio" value="Excellent" required> Excellent <br>
                        <input type="radio" name="communication" class="radio" value="Very Good" required> Very Good <br>
                        <input type="radio" name="communication" class="radio" value="Good" required> Good <br>
                        <input type="radio" name="communication" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="communication" class="radio" value="Poor" required> Poor
                    </div>

                    <div class="form-group">
                        <label>12. Infrastructure ( क्या ट्रेनिंग के लिए कंपनी द्वारा प्रदान किया गया बुनियादी ढाँचा (जैसे कंप्यूटर, सॉफ्टवेयर, इंटरनेट , डेस्क, कुर्सी काम करने की जगह, पीने का पानी और सुरक्षा) आपके लिए पर्याप्त और संतोषजनक था? )</label>
                        <input type="radio" name="infrastructure" class="radio" value="Excellent" required> Excellent <br>
                        <input type="radio" name="infrastructure" class="radio" value="Very Good" required> Very Good <br>
                        <input type="radio" name="infrastructure" class="radio" value="Good" required> Good <br>
                        <input type="radio" name="infrastructure" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="infrastructure" class="radio" value="Poor" required> Poor
                    </div>

                    <div class="form-group">
                        <label>13. नियमित कोर्स के अलावा, क्या कंपनी ने कोई अतिरिक्त गतिविधि या Session (जैसे वर्कशॉप, गेस्ट लेक्चर या टीम-बिल्डिंग एक्सरसाइज) आयोजित किए थे?</label>
                        <input type="radio" name="extra_activities" class="radio" value="Yes" required> Yes <br>
                        <input type="radio" name="extra_activities" class="radio" value="No" required> No
                    </div>

                    <div class="form-group">
                        <label>14. Overall Company Experience</label>
                        <input type="radio" name="company_experience" class="radio" value="Excellent" required> Excellent <br>
                        <input type="radio" name="company_experience" class="radio" value="Very Good" required> Very Good <br>
                        <input type="radio" name="company_experience" class="radio" value="Good" required> Good <br>
                        <input type="radio" name="company_experience" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="company_experience" class="radio" value="Poor" required> Poor
                    </div>

                    <div class="form-group">
                        <label>15.Remark (टिप्पणी ) - ऊपर कंपनी के बारे में दी गयी रेटिंग के सम्बन्ध में यदि कुछ अलग से बताना चाहते हैं तो ...</label>
                        <input type="text" name="company_remark" class="form-control">
                    </div>

                    <button type="button" class="btn" onclick="prevStep()">Previous Section</button>
                    <button type="button" class="btn" onclick="nextStep()">Next Section</button>
                </div>

                <!-- Section 3 -->
                <div class="step">
                    <h3 class="section-title">Section 3</h3>
                    <h3>Trainer & Classroom Experience</h3>

                    <div class="form-group">
                        <label>16. Trainer Teaching Style Experience :

                            क्या ट्रेनर ने विषय को स्पष्ट और आसान तरीके से समझाया? (क्या आपको सारी बातें आसानी से समझ आईं?)
                            ट्रेनिंग के दौरान, क्या ट्रेनर ने आपके सवालों और शंकाओं को ध्यान से सुना और उनका जवाब दिया?

                            कुल मिलाकर, आप ट्रेनर के पढ़ाने का तरीका कैसा था ? </label>
                        <input type="radio" name="trainer_style" class="radio" value="Excellent" required> Excellent <br>
                        <input type="radio" name="trainer_style" class="radio" value="Very Good" required> Very Good <br>
                        <input type="radio" name="trainer_style" class="radio" value="Good" required> Good <br>
                        <input type="radio" name="trainer_style" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="trainer_style" class="radio" value="Poor" required> Poor
                    </div>

                    <div class="form-group">
                        <label>17.Technical Knowledge of Trainer

                            क्या ट्रेनर ने नई तकनीकों और उद्योग के रुझानों (industry trends) के बारे में जानकारी दी?
                            क्या ट्रेनर को अपने विषय का अच्छा ज्ञान था?
                            क्या ट्रेनर आपके तकनीकी सवालों के सही जवाब दे पाते थे?</label>
                        <input type="radio" name="trainer_knowledge" class="radio" value="Excellent" required> Excellent <br>
                        <input type="radio" name="trainer_knowledge" class="radio" value="Very Good" required> Very Good <br>
                        <input type="radio" name="trainer_knowledge" class="radio" value="Good" required> Good <br>
                        <input type="radio" name="trainer_knowledge" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="trainer_knowledge" class="radio" value="Poor" required> Poor
                    </div>

                    <div class="form-group">
                        <label>18. Project Status</label>
                        <input type="radio" name="project_status" class="radio" value="25% or less" required> 25% से कम <br>
                        <input type="radio" name="project_status" class="radio" value="25-50%" required> 25%-50% <br>
                        <input type="radio" name="project_status" class="radio" value="51-75%" required> 51%-75% <br>
                        <input type="radio" name="project_status" class="radio" value="76-99%" required> 76%-99% <br>
                        <input type="radio" name="project_status" class="radio" value="100%" required> 100% पूरा <br>
                    </div>

                    <div class="form-group">
                        <label>19. Overall Trainer Experience</label>
                        <input type="radio" name="trainer_experience" class="radio" value="Excellent" required> Excellent <br>
                        <input type="radio" name="trainer_experience" class="radio" value="Very Good" required> Very Good <br>
                        <input type="radio" name="trainer_experience" class="radio" value="Good" required> Good <br>
                        <input type="radio" name="trainer_experience" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="trainer_experience" class="radio" value="Poor" required> Poor
                    </div>

                    <div class="form-group">
                        <label>20. Remark</label>
                        <input type="text" name="trainer_remark" class="form-control" >
                    </div>

                    <button type="button" class="btn" onclick="prevStep()">Previous Section</button>
                    <button type="button" class="btn" onclick="nextStep()">Next Section</button>
                </div>

                <!-- Section 4 -->
                <div class="step">
                    <h3 class="section-title">Section 4</h3>
                    <h3>Other Facility Feedback</h3>

                    <div class="form-group">
                        <label>21. Location Ease</label>
                        <input type="radio" name="location_ease" class="radio" value="Easy to find" required> Easy to find <br>
                        <input type="radio" name="location_ease" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="location_ease" class="radio" value="Difficult to find" required> Difficult to find <br>
                        <input type="radio" name="location_ease" class="radio" value="Too far" required> Too far <br>
                    </div>

                    <div class="form-group">
                        <label>22. Accommodation</label>
                        <input type="radio" name="accommodation" class="radio" value="Excellent" required> Excellent <br>
                        <input type="radio" name="accommodation" class="radio" value="Very Good" required> Very Good <br>
                        <input type="radio" name="accommodation" class="radio" value="Good" required> Good <br>
                        <input type="radio" name="accommodation" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="accommodation" class="radio" value="Poor" required> Poor <br>
                        <input type="radio" name="accommodation" class="radio" value="Own Home" required> अपने स्वयं के घर / परिवार में
                    </div>

                    <div class="form-group">
                        <label>23. Fooding Facility</label>
                        <input type="radio" name="food_facility" class="radio" value="Excellent" required> Excellent <br>
                        <input type="radio" name="food_facility" class="radio" value="Very Good" required> Very Good <br>
                        <input type="radio" name="food_facility" class="radio" value="Good" required> Good <br>
                        <input type="radio" name="food_facility" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="food_facility" class="radio" value="Poor" required> Poor <br>
                        <input type="radio" name="food_facility" class="radio" value="Own Food" required> अपनी व्यवस्था से घर का खाना
                    </div>

                    <button type="button" class="btn" onclick="prevStep()">Previous Section</button>
                    <button type="button" class="btn" onclick="nextStep()">Next Section</button>
                </div>

                <!-- Section 5 -->
                <div class="step">
                    <h3 class="section-title">Section 5</h3>
                    <h3>Overall Feedback</h3>

                    <div class="form-group">
                        <label>24. Overall Training Experience</label>
                        <input type="radio" name="overall_exp" class="radio" value="Excellent" required> Excellent <br>
                        <input type="radio" name="overall_exp" class="radio" value="Very Good" required> Very Good <br>
                        <input type="radio" name="overall_exp" class="radio" value="Good" required> Good <br>
                        <input type="radio" name="overall_exp" class="radio" value="Average" required> Average <br>
                        <input type="radio" name="overall_exp" class="radio" value="Poor" required> Poor
                    </div>

                    <div class="form-group">
                        <label>25. Remark</label>
                        <input type="text" name="remark" class="form-control ">
                    </div>

                    <button type="button" class="btn" onclick="prevStep()">Previous Section</button>
                    <button type="submit" class="btn">Submit</button>
                </div>

            </form>
        </div>
    </div>
    <?php   include('../footer.php') ?>
    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll(".step");

        function showStep(stepIndex) {
            steps.forEach((step, index) => {
                step.style.display = index === stepIndex ? "block" : "none";
            });
        }

      function nextStep() {

    let currentInputs = steps[currentStep].querySelectorAll("input, select, textarea");
    let valid = true;

    currentInputs.forEach(function(input){

        if(!input.checkValidity()){
            input.reportValidity();
            valid = false;
        }

    });

    // Technology validation (at least one)
    if(currentStep === 0){
        let tech = document.querySelectorAll("input[name='technology[]']:checked");

        if(tech.length === 0){
            alert("Please select at least one Technology");
            valid = false;
        }
    }

    if(valid){
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    }

}

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        showStep(currentStep);
   
function setLocation(company){

    var location = company.getAttribute("data-location");

    document.getElementById("locationField").value = location;

}
function disableTextbox(){

    let textbox = document.getElementById("trainerTextbox");

    textbox.value = "";
    textbox.disabled = true;

}

function disableRadios(){

    let textbox = document.getElementById("trainerTextbox");
    let radios = document.getElementsByName("trainer_id");

    if(textbox.value.length > 0){

        radios.forEach(function(r){
            r.checked = false;
            r.disabled = true;
        });

    }else{

        radios.forEach(function(r){
            r.disabled = false;
        });

    }

}
</script>

</body>

</html>