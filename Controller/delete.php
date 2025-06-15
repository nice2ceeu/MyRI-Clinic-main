
<?php
include("../config/database.php");

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("Delete FROM meds WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo

        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Medicine removed successfully.';
        header("Location: ../view/pages/inventory.php");
        exit;
    } else {
        echo
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Failed to Delete the Medicine';
        header("Location: ../view/pages/inventory.php");
        exit;
    }

    $stmt->close();
}

?>