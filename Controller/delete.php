
<?php
include("../config/database.php");

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("Delete FROM meds WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Medicine Removed');
            window.location.href ='../view/pages/inventory.php'</script>";
    } else {
        echo "<script>alert('Failed to Delete');
            window.location.href ='../view/pages/inventory.php'
            </script>";
    }

    $stmt->close();
}

?>