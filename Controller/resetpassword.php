<?php
include('../config/database.php');
if (isset($_POST['reset'])) {
    $id = $_POST['id'];
    $defaultPass = "00000000";

    $hashed = password_hash($defaultPass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("Update admin set password=? where id=?");
    $stmt->execute([$hashed, $id]);

    echo "<script>alert('Password has been reset. Password:00000000')
    window.location.href ='../view/pages/enrolledstudentlist.php'
    </script>";
}

if (isset($_POST['reset-password'])) {
    $id = $_POST['id'];
    $currentPass = $_POST['currentPass'];
    $newPass = $_POST['newPass'];
    $confirmPass = $_POST['confirmPass'];

    if ($newPass === $confirmPass && strlen($newPass) > 8) {


        $stmt = $conn->prepare("SELECT password FROM admin WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($currentPass, $row['password'])) {
            $hashed = password_hash($newPass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
            $stmt->execute([$hashed, $id]);

            echo "<script>
                alert('Password Successfully Changed!');
                window.location.href = '../view/pages/userprofile.php';
            </script>";
        } else {
            echo "<script>
                alert('Current Password does not match our records.');
                window.location.href = '../view/pages/userprofile.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Passwords must match and be longer than 8 characters.');
            window.location.href = '../view/pages/userprofile.php';
        </script>";
    }
}
