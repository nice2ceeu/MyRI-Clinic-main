<?php
require '../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\IOFactory;

include('../config/database.php');

if (isset($_POST['upload'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $filePath = $_FILES["file"]["tmp_name"];
        $success = 0;
        $failed = 0;

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        $student = "student";
        foreach ($rows as $row) {
            try {
                $stmt = $conn->prepare("INSERT INTO admin (firstname, lastname, username, user_role) VALUES (?, ?, ?,?)");
                $stmt->execute([strtolower($row[0]), strtolower($row[1]), $row[2], $student]);
                $success++;
            } catch (Exception $ex) {
                $failed++;
                
            }
        }
        if ($success == 0 && $failed == 0) {
            echo "<script>alert('No records found to process');
          window.location.href = '../../View/pages/enrolledstudentlist.php';
          </script>";
        } else if ($success == 0) {
            echo "<script>alert('Error Occurred: Records might already exist');
          window.location.href = '../../View/pages/enrolledstudentlist.php';
          </script>";
        } else if ($failed > 0) {
            echo "<script>alert('$success Successfully Recorded and $failed already existed');
          window.location.href = '../../View/pages/enrolledstudentlist.php';
          </script>";
        } else {
            echo "<script>alert('All records are uploaded successfully');
          window.location.href = '../../View/pages/enrolledstudentlist.php';
          </script>";
        }
    } else {
        echo "File upload failed.";
    }
}
