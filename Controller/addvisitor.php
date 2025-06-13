<?php

use BcMath\Number;

include("../config/database.php");

if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $grade = $_POST["grade"];
    $section = $_POST["section"];
    $complaint = $_POST["complaint"];



    if ($firstname == "" || $lastname == "" || $complaint == "" || $grade == "" || $section == "") {
        echo "<script>alert('Please fill all Fields');
        window.location.href = '../view/pages/Clinic-Patient.php';
        </script>";
    } else {

        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d");
        $lowfirst = strtolower($firstname);
        $lowlast = strtolower($lastname);
        $lowsec = strtolower($section);
        $checkin = date("h:i:s A");
        
        $stmt = $conn->prepare("INSERT INTO visitor (firstname, lastname, complaint,grade,section, checkin, _date) VALUES (?, ?, ?, ?, ?,?,?)");
        $stmt->bind_param("sssisss", $lowfirst, $lowlast, $complaint, $grade, $lowsec, $checkin, $date);
        $stmt->execute();
        

        echo "<script>
            alert('Patient added');
            window.location.href = '../view/pages/Clinic-Patient.php';
        </script>";
    }
}
