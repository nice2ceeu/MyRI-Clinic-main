<?php
include('../config/database.php');

if (isset($_POST['save_mode'])) {
    $id = $_POST['id'];
    $fullname = $_POST['new_fullname'];
    $grade_section = $_POST['new_grade'];
    $birthdate = $_POST['new_birthday'];
    $age = $_POST['new_age'];
    $gender = $_POST['new_gender'];
    $height = $_POST['new_height'];
    $weight = $_POST['new_weight'];
    $address = $_POST['new_address'];
    $parent = $_POST['new_parent'];
    $contact = $_POST['new_number'];
    $asthma = $_POST['asthma'];
    $epilepsy = $_POST['epilepsy'];
    $food = $_POST['food'];
    $foodcause = $_POST['food'] == "no" ? null : $_POST['new_food_allergic'];
    $insect = $_POST['insect'];
    $insectcause = $_POST['insect'] == "no" ? null : $_POST['new_insect_bites'];

    $stmt = $conn->prepare("UPDATE medicalform SET
        fullname = ?,
        grade_section = ?,
        birthdate = ?,
        age = ?,
        gender = ?,
        height = ?,
        _weight = ?,
        _address = ?,
        parent = ?,
        contact = ?,
        asthma = ?,
        epilepsy = ?,
        food = ?,
        foodcause = ?,
        insect = ?,
        insectcause = ?
        WHERE id = ?");

    $stmt->bind_param(
        "sssisiisssssssssi",
        $fullname,
        $grade_section,
        $birthdate,
        $age,
        $gender,
        $height,
        $weight,
        $address,
        $parent,
        $contact,
        $asthma,
        $epilepsy,
        $food,
        $foodcause,
        $insect,
        $insectcause,
        $id
    );

    if ($stmt->execute()) {
        echo "<script>
            alert('Record Updated');
            window.location.href= '../view/pages/studentlist.php';
        </script>";
    } else {
        echo "<script>
            alert('Error updating record.');
        </script>";
    }
}
